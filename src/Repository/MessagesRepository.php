<?php

/*
 * This file is part of the "php-paradise/array-keys-converter" package.
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Messages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Messages find($id, $lockMode = null, $lockVersion = null)
 * @method null|Messages findOneBy(array $criteria, array $orderBy = null)
 * @method Messages[]    findAll()
 * @method Messages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Messages::class);
    }

    public function getQuery($object)
    {
        $qb = $this->createQueryBuilder('q')
                    ->select('IDENTITY(q.topics)', 'q.text')
                    ->andWhere('q.text LIKE :object')
                    ->setParameter('object', '%' . $object['question'] . '%')
                    ->getQuery();

        return $qb->execute();
    }

    public function lastMessage($topic)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->setMaxResults(1);
        $qb->orderBy('t.id', 'DESC');

        return $qb->getQuery()->getSingleResult();
    }
}
