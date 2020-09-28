<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;

/**
 * Controlling post's of blog
 * @package App\Http\Controllers\Blog\Admin
 */

class PostController extends BaseController
{

    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Contracts\View\Factory
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Contracts\View\Factory
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $item = new BlogPost();

        $categoryList = $this->blogCategoryRepository->getForComboBox($item->id);

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if ($item){
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);
            return redirect()->route('blog.admin.posts.edit', [$item->id])
                             ->with(['success' => 'Successful saved']);

        }else{
            return back()->withErrors(['msg' => 'Error saving'])
                         ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|
     * @return \Illuminate\Contracts\View\Factory|
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)){
            abort(404);
        }

        $categoryList =
            $this->blogCategoryRepository->getForComboBox($item);

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item))
        {
            return back()
                ->withErrors(['msg' => "Post id=[{$id}] not found"])
                ->withInput();}

        $data = $request->all();

        $result = $item->update($data);

        if($result) {
            return  redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Successful saved']);
        }else{
            return back()
                ->withErrors(['msg' => 'Error saving'])
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //SoftDelete
        $result = BlogPost::destroy($id);

        //Full delete from DB
        //$result = BlogPost::find($id)->forceDelete();

        if ($result){

            BlogPostAfterDeleteJob::dispatch($id)->delay(10);

            return redirect()
                ->route('blog.admin.posts.index')
                ->with(['success' => "Post id [$id] deleted"]);
        }else{
            return back()->withErrors(['msg' => 'Error deteting']);
        }
    }
}
