<?php

/**
 * ArticlesTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ArticlesTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ArticlesTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Articles');
    }



    /**
     * 'Selecta' po jedan najnoviji clanak iz svake kategorije za prikaz na naslovnoj strani
     * 
     * @return array $result
     */
    public function getLatestFromAllCategories()
    {

      $q = Doctrine_Manager::getInstance()->getCurrentConnection();

      $result = $q->execute("SELECT a.id,a.title,a.text,a.published_at,c.name,c.id AS c_id,a.photo
                             FROM articles a
                             INNER JOIN
                             (SELECT articles.category_id,MAX(articles.published_at) AS latest FROM
                             articles  GROUP BY articles.category_id) b ON
                             a.category_id=b.category_id AND a.published_at=b.latest
                             INNER JOIN categories c ON a.category_id=c.id WHERE a.published=1");

      return $result->fetchAll();
    }
    
    
    /**
     * 'Selecta' sve clanke iz odabrane kategorije
     * 
     * @param integer categories.id
     */
    
    public function getAllFromCategory($id)
    {
      //SELECT * FROM `articles` INNER JOIN categories ON articles.category_id=categories.id WHERE categories.id=1
    
      $q = $this->createQuery()
      ->select('a.id,a.title,a.text,a.published_at,c.name')
      ->from('Articles a')
      ->innerJoin('a.Categories c')
      ->where('c.id=?',$id)
      ->andWhere('a.published=?',1);
      
      return $q->execute();
    }

    
    /**
     * 'Selecta' jedan odabrani clanak
     * 
     * @param integer articles.id
     */

    public function getOneArticle($id)
    {
      $q = $this->createQuery()
      ->select('a.id,a.title,a.text,a.published_at,u.id,p.id,p.name,p.surname')
      ->from('Articles a')
      ->innerJoin('a.Users u')
	    ->leftJoin('a.Comments c')
      ->where('a.id=?',$id)
      ->andWhere('a.published=?',1);
     
      return $q->fetchOne();
    }
    
     /**
     *  Broji komentare koji pripadaju odabranom clanku
     * 
     * @param integer article_id
     */
    public function countComments($id)
    {
    
     // SELECT count(id) FROM `comments` WHERE article_id=4
     
    $q = $this->createQuery('a')
         ->select('a.id,COUNT(c.article_id) AS cmnts')
         ->from('Articles a')
         ->innerJoin('a.Comments c')
         ->where('c.article_id=?',$id);
         
         return $q->fetchOne();
    
    }
    
    /**
    * 'Selecta' komentare koji pripadaju clanku ciji id se daje kao parametar
    */
    public function getComm($id)
    {
     $q = $this->createQuery('a')
          ->select('a.id,c.text,c.published_at')
          ->from('Articles a')
          ->innerJoin('a.Comments c')
          ->where('c.article_id=?',$id)
          ->andWhere('c.published=?',1);
     
          return $q->execute();
          
    }

	

  /**
  * Selecta sve clanke za backend listu s tim da joina categories i users. Select zavisi od credentiala i username-a.
  */
   public function getArticlesByCredential()
   {
    $userId = sfContext::getInstance()->getUser()->getAttribute( 'id' );

    if(sfContext::getInstance()->getUser()->hasCredential('author')===true):

      $crdntl = 'author';
  
    else:
   
      $crdntl = 'editor';

    endif;
    
    if($crdntl =='editor'):

      $q = $this->createQuery('a')
         ->select('a.id,a.title,a.text,a.published,a.read_count,a.category_id,a.published_at,a.user_id,a.photo,CONCAT(u.name," ",u.surname) AS author,c.name AS c_name')
         ->from('Articles a')
         ->innerJoin('a.Users u')
         ->innerJoin('a.Categories c')
         ->orderBy('a.published_at DESC');
      return $q;
    
    else:
      
      $q = $this->createQuery('a')
        ->select('a.id,a.title,a.text,a.published,a.read_count,a.category_id,a.published_at,a.user_id,a.photo,CONCAT(u.name," ",u.surname) AS author,c.name AS c_name')
        ->from('Articles a')
        ->innerJoin('a.Users u')
        ->innerJoin('a.Categories c')
        ->where('user_id = ?', $userId)
        ->orderBy('a.published_at DESC');
      return $q;
    
    endif;
   }




/**
*  Prima ID clanka i varijablu published: 1 ili 0. Vrsi update recorda.
*/
  public function updateArticle($id,$pub)
  {
    $q = $this->createQuery()
        ->update('Articles')
        ->set('published','?',$pub)
        ->where('id=?',$id);

    $q->execute();
    return 'ok';
  }



  /**
  * Izvrsava update query za clanak
  *
  * @param string $title naslov clanka
  * @param string $text tekst clanka
  * @param int $cat category_id
  * @param int $pub published
  * @param int $usr user_id
  * @param string $photo url slike
  * @param int $id id clanka
  */
  public function updateArticletotal($title,$text,$cat,$pub,$usr,$photo,$id)
  {
   
    if($photo!=''):
      $q = $this->createQuery()
                ->update('Articles a')
                ->set('a.title','?',$title)
                ->set('a.text','?',$text)
                ->set('a.category_id','?',$cat)
                ->set('a.published','?',$pub)
                ->set('a.user_id','?',$usr)
                ->set('a.photo','?',$photo)
                ->where('a.id=?',$id);
    else:
      $q = $this->createQuery()
                ->update('Articles a')
                ->set('a.title','?',$title)
                ->set('a.text','?',$text)
                ->set('a.category_id','?',$cat)
                ->set('a.published','?',$pub)
                ->set('a.user_id','?',$usr)
                ->where('a.id=?',$id);
    endif;

    $q->execute();
  }

  /**
  * Brise tagove pri update-u clanka, koji su izbrisani na formi
  */
  public function deleteTags($id,$tags_arr)
  {
    foreach($tags_arr as $key=>$tag):

    $q = $this->createQuery()
              ->delete('ArticlesTags at')
              ->where('at.articles_id=?',$id)
              ->andWhere('at.tags_id=?',$key);
    $q->execute();

    endforeach;
  }

 
  /**
  * Selecta i vraca clanke koji imaju odabrani tag
  */
  public function getTaggedArticles($tag)
  {
   
   $q = $this->createQuery('a')
             ->select('a.id,a.title,a.text,t.text AS tagtext,c.name,c.id AS categoryId')
             ->from('Articles a')
             ->innerJoin('a.Tags t')
             ->innerJoin('a.Categories c')
             ->where('t.text=?',rawurldecode($tag))
             ->andWhere('a.published=?',1);

   return $q->execute();
  }


  /**
  * Povecava read_count clanka za 1
  */
  public function articleIncrement($id)
  {
    $q = $this->createQuery()
              ->update('Articles a')
              ->set('a.read_count', '(read_count+1)')
              ->where('a.id = ?', $id);

    $q->execute();
  }
}