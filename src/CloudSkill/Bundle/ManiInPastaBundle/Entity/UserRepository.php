<?php

namespace CloudSkill\Bundle\ManiInPastaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository {

    public function deleteAll() {
        $qb=$this->createQueryBuilder('User');
        $qb->delete();
        $query=$qb->getQuery();
        return $query->execute();
         
        
//        $repository = $this->_em->getRepository('My\\Entity');
//        $query=$this->
//        $query = $this->createQuery('DELETE FROM user u ');
//$query->setParameter(1, $id);
//        $query->execute();
    }

}
