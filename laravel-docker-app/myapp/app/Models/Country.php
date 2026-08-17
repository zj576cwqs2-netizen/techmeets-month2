public function posts()
{
    return $this->hasManyThrough(Post::class, Use::class);

}
$country = Country::find(1);
$country->posts;
