<?php

namespace Zeega\CoreBundle\Twig\Extensions;

use Zeega\DataBundle\Entity\Site;
use Zeega\DataBundle\Entity\User;
use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Zeega\CoreBundle\Helpers\ItemCustomNormalizer;
use Symfony\Component\HttpFoundation\Response;

class HeaderTwigExtension extends \Twig_Extension
{
	protected $doctrine;

	public function __construct($doctrine, $securityContext, $session)
	{
        $this->doctrine = $doctrine;
		$this->securityContext = $securityContext;
		$this->session = $session;
    }

    public function getGlobals()
    {
        $securityToken = $this->securityContext->getToken();
        if(isset($securityToken))
        {
            $user = $this->securityContext->getToken()->getUser();
    		if(isset($user) && $user != "anon.")
    		{
        		$projects = $this->doctrine->getRepository('ZeegaDataBundle:Project')->findByUser($user->getId());

	            return array(
    				'title'=>$currentSite->getTitle(),
    				'short'=>$currentSite->getShort(),
    				'user_id' => $user->getId(),
    				'myprojects'=> $projects,
    				'displayname' => $user->getDisplayName(),
    			);
    		}
        }

        return array(
			'title' => 'Unknown',
			'short' => 'Unknown',
			'user_id' => -1,
			'myprojects'=> 'Unknown',
			'displayname' => 'Unknown'
			);
    }
	
	public function getFilters()
	{
        return array(
            'json_encode_entity' => new \Twig_Filter_Method($this, 'entityNormalizer'),
            'unserialize_array' => new \Twig_Filter_Method($this, 'unserializeArray'),
        );
    }

    public function entityNormalizer($arrayObject)
    {
        $serializer = new Serializer(array(new ItemCustomNormalizer()),array('json' => new JsonEncoder()));
        return $serializer->serialize($arrayObject, 'json');
    }

    public function unserializeArray($arrayObject)
    {
    	if(isset($arrayObject)) {
    	
    		$arrayObject = unserialize($arrayObject);
    		if(is_array($arrayObject)){
    			return $arrayObject;	
    		}
    	}
    	
    	return array();
    }

	
	public function getName()
	{
		return 'zeega-header';
	}
}
