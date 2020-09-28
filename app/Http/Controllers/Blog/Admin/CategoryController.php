<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;

class CategoryController extends BaseController
{
    /**
     * @var BlogCategoryRepository
     */

    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|
     * @return \Illuminate\Contracts\View\Factory|
     * @return \Illuminate\Http\Response|
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(10);

        return view('blog.admin.categories.index', compact('paginator'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|
     * @return \Illuminate\Contracts\View\Factory|
     * @return \Illuminate\Http\Response|
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $item = new BlogCategory();

        $categoryList = $this->blogCategoryRepository->getForComboBox($item->id);

        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request)
    {

        $data = $request->input();
        $item = (new BlogCategory())->create($data); //Create object and will add in DB

        if ($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Successfully saved']);
        } else {
            return back()->withErrors(['msg' => 'Saving error'])
                ->withInput();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @param BlogCategoryRepository $categotyRepository
     *
     * @return \Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Contracts\View\Factory|
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */

    public function edit($id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);
//        $v['title_before'] = $item->title;
//
//        $item->title = 'ASDasdasdaSD asdasd 1212';
//
//        $v['title_after'] = $item->title;
//        $v['getAttribute'] = $item->getAttribute('title');
//        $v['attributesToArray'] = $item->attributesToArray();
//        $v['attributes'] = $item->attribtes['title'];
//        $v['getAttributeValue'] = $item->getAttributeValue('title');
//        $v['getMutatedAttributes'] = $item->getMutatedAttributes();
//        $v['hasGetMutator for title'] = $item->hasGetMutator('title');
//        $v['toArray'] = $item->toArray();
        if (empty($item)){
            abort(404);
        }

        $categoryList =
            $this->blogCategoryRepository->getForComboBox($item->parent_id);

        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {

        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Post id=[{$id}] is not found"])
                ->withInput();
        }

        $data = $request->all();

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Is successfully saved']);
        } else {
            return back()
                ->withErrors(['msg' => 'Saving error'])
                ->withInput();
        }
    }

}
