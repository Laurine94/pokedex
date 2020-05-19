<?php

namespace App\Repository;

use App\Entity\PokemonExistant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PokemonExistant|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonExistant|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonExistant[]    findAll()
 * @method PokemonExistant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonExistantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonExistant::class);
    }




    /**
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getPokemonByDresseur($dresseur){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT pokemon_existant.id as id ,nom, sexe, niveau, xp FROM pokemon_existant JOIN ref_pokemon_type ON pokemon_existant.pokemon_type_id=ref_pokemon_type.id WHERE dresseur_id= '.$dresseur.';';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countPokemonExistantByIdDresseur($dresseur)
    {
        return $this->createQueryBuilder('p')
        ->select('COUNT(p.id)')
        ->andWhere('p.dresseur = :val')
        ->setParameter('val', $dresseur)
        ->getQuery()
        ->getSingleScalarResult();
    }

    /**
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getStatsByTypePokemonExistant($dresseur){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT libelle as type, nb FROM ((SELECT type_1 as type, count(type_1) as nb from ref_pokemon_type INNER JOIN pokemon_existant 
        ON ref_pokemon_type.id = pokemon_existant.pokemon_type_id WHERE pokemon_existant.dresseur_id='.$dresseur.' GROUP BY type_1)
        UNION
        (SELECT type_2 as type, count(type_2) as nb from ref_pokemon_type INNER JOIN pokemon_existant ON ref_pokemon_type.id = pokemon_existant.pokemon_type_id WHERE pokemon_existant.dresseur_id='.$dresseur.' GROUP BY type_2)) as tab 
        LEFT JOIN ref_elementary_type on type = id WHERE nb > 0 ;';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getEvolutionByDresseur($dresseur){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(pokemon_existant.id) FROM pokemon_existant JOIN ref_pokemon_type ON pokemon_existant.pokemon_type_id=ref_pokemon_type.id WHERE dresseur_id='.$dresseur.' AND ref_pokemon_type.evolution=1;' ;

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

     /**
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getCourbePokemon($dresseur,$idPokemon){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT type_courbe_niveau FROM pokemon_existant JOIN ref_pokemon_type ON pokemon_existant.pokemon_type_id=ref_pokemon_type.id WHERE dresseur_id='.$dresseur.' AND pokemon_existant.id='.$idPokemon.';';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // /**
    //  * @return PokemonExistant[] Returns an array of PokemonExistant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PokemonExistant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
