# PHP Object Hydrator

The library allows to hydrate objects from an array and extract raw objects's values to an array.

## Installation

Install with composer:

```bash
composer require elisdn/php-hydrator
```

## Usage samples

Hydrating an object from an associative array:

~~~php
$post = $this->hydrator->hydrate(Post::class, [
    'id' => $id,
    'date' => $date,
    'title' => $title,
])
~~~

Extracting of object values to an array by list of properies:

~~~php
$data = $this->hydrator->extract($post, ['id', 'date', 'title'])
~~~

For example if we have `Post` entity:

```php
class Post
{
    private $id;
    private $title;
    private $date;

    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = new DateTimeImmutable();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
}
```

then we can use the hydrator in any repository class:

```php
class SqlPostRepository implements PostRepository
{
    private $db;
    private $hydrator;

    public function get($id): Post
    {
        if (!$row = $this->db->selectOne('posts', ['id' => $id])) {
            throw new NotFoundException('Post not found.');
        }
    
        return $this->hydrator->hydrate(Post::class, [
            'id' => $row['id'],
            'date' => DateTimeImmutable::createFromFormat('Y-m-d', $row['create_date']),
            'title' => $row['title'],
        ]);
    }

    public function persist(Post $post): void
    {
        $data = $this->hydrator->extract($post, ['id', 'date', 'title']);
    
        $this->db->insert('posts', [
            'id' => $data['id'],
            'create_date' => $data['date']->format('Y-m-d'),
            'title' => $data['title'],
        ]);
    }
}
```
