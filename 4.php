<?php
interface Box
{
  public function setData($key, $value);
  public function getData($key);
  public function save();
  public function load();
}

abstract class BoxAbstract implements Box
{
    protected $data = [];

    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function getData($key)
    {
        return $this->data[$key] ?? null;
    }

    public abstract function save();
    public abstract function load();
}

class FileBox extends BoxAbstract
{
  private $file;

  public function __construct($file)
  {
      $this->file = $file;
  }

  public function save()
  {
      file_put_contents($this->file, serialize($this->data));
  }

  public function load()
  {
      $this->data = unserialize(file_get_contents($this->file));
  }
}

class DbBox extends BoxAbstract
{
  private $pdo;

  public function __construct(\PDO $pdo)
  {
      $this->pdo = $pdo;
  }

  public function save()
  {
      try {
          $this->pdo->beginTransaction();

          $this->pdo->query('DELETE FROM box')->execute();

          $stmt = $this->pdo->prepare("INSERT INTO box (key, value) VALUES (:key, :value)");

          foreach ($this->data as $key => $value) {
              $stmt->bindValue(':key', $key);
              $stmt->bindValue(':value', serialize($value));
              $stmt->execute();
          }
          $this->pdo->commit();
      } catch (\Exception $e){
          $this->pdo->rollback();
          throw $e;
      }
  }

  public function load()
  {
      $stmt = $this->pdo->query('SELECT key, value FROM box_items');

      $data = [];

      while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
          $data[$row['key']] = unserialize($row['value']);
      }

      $this->data = $data;
  }
}
 ?>
