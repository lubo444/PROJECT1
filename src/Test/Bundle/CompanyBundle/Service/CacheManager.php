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
        $objectCacheId = $this->entityManager->getClassMetadata($className)->getName() . $objectId;
        $object = $this->apcCache->fetch($objectCacheId);

        if (!$object) {
            $object = $this->updateCachedObject($className, $objectId, $cachedTime);
        }

        return $object;
    }

    public function updateCachedObject($className, $objectId, $cachedTime = 60)
    {
        $objectCacheId = $this->entityManager->getClassMetadata($className)->getName() . $objectId;

        $this->entityManager->clear();
        $object = $this->entityManager->getRepository($className)->find($objectId);
        $this->apcCache->save($objectCacheId, $object, $cachedTime);

        return $object;
    }

    public function deleteCachedObject($className, $objectId)
    {
        $objectCacheId = $this->entityManager->getClassMetadata($className)->getName() . $objectId;
        
        $this->apcCache->delete($objectCacheId);
    }

}
