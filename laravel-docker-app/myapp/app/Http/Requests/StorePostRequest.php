public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'body'  => 'required|string',
    ];
}

public function store(StorePostRequest $request)
{
    Post::create($request->validated()); 
    return redirect()->route('posts.index');
}