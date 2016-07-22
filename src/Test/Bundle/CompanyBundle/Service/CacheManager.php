<?php

namespace Test\Bundle\CompanyBundle\Service;

/**
 * @Service("test.cache_manager")
 */
class CacheManager
{

    private $apcCache;
    private $entityManager;

    public function __construct($apcCache, $entityManager)
    {
        $this->apcCache = $apcCache;
        $this->entityManager = $entityManager;
    }

    public function getCachedObject($className, $objectId, $cachedTime = 60)
    {
        $idCachedObj = $this->getIdCacheObj($className, $objectId);
        
        $object = $this->apcCache->fetch($idCachedObj);

        if (!$object) {
            $object = $this->updateCachedObject($className, $objectId, $cachedTime);
        }

        return $object;
    }

    public function updateCachedObject($className, $objectId, $cachedTime = 60)
    {
        $idCachedObj = $this->getIdCacheObj($className, $objectId);
        
        $this->entityManager->clear();
        $object = $this->entityManager->getRepository($className)->find($objectId);
        
        $this->apcCache->save($idCachedObj, $object, $cachedTime);

        return $object;
    }

    public function deleteCachedObject($className, $objectId)
    {
        $idCachedObj = $this->getIdCacheObj($className, $objectId);
        
        $this->apcCache->delete($idCachedObj);
    }

    private function getIdCacheObj($className, $objectId)
    {
        return $this->entityManager->getClassMetadata($className)->getName() . $objectId;
    }

}
