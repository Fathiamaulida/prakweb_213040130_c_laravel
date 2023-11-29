<u></u>se App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class DashboardPostController extends Controller
{
    /**
@@ -41,7 +43,21 @@ public function create()
     */
    public function store(Request $request)
    {
        return $request;
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            // 'image' => 'image|file|max:1024',
            'body' => 'required'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::create($validatedData);

        return redirect('/dashboard/posts')->with('success', 'New post has been added!');

    }

    /**
@@ -65,7 +81,10 @@ public function show(Post $post)
     */
    public function edit(Post $post)
    {
        //
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
@@ -77,7 +96,25 @@ public function edit(Post $post)
     */
    public function update(Request $request, Post $post)
    {
        //
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            // 'image' => 'image|file|max:1024',
            'body' => 'required'
        ];

        if($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::where('id', $post->id)->update($validatedData);

        return redirect('/dashboard/posts')->with('success', 'New post has been update!');
    }

    /**
@@ -88,10 +125,13 @@ public function update(Request $request, Post $post)
     */
    public function destroy(Post $post)
    {
        //
        Post::destroy($post->id);

        return redirect('/dashboard/posts')->with('success', 'New post has been deleted!');
    }

    public function checkSlug(Request $request) {
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    } }}