@php /** @var \App\Models\BlogPost $item */ @endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($item->is_published)
                Publicated
                @else
                Draft
                @endif
            </div>
            <div class="card-body">
                <div class="card-title"></div>
                <div class="card-subtitle mb-2 text-muted"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#maindata" role="tab">Main data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#adddata" role="tab">Additional data</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div class="tab-pane active" id="maindata" role="labpanel">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input name="title" value="{{$item->title}}"
                            id="title"
                            type="text"
                            class="form-control"
                            minlength="3"
                            required>
                        </div>
                        <div class="form-group">
                            <label for="content_raw">Article</label>
                            <textarea name="content_raw"
                                      id="content_raw"
                                      class="form-control"
                                      rows="20">{{old('content_raw', $item->content_raw)}}</textarea>
                        </div>
                    </div>
                    <div class="lab-pane" id="adddata" role="labpanel">
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id"
                                    id="category_id"
                                    class="form-control"
                                    placeholder="Choose a category"
                                    required>
                                @foreach($categoryList as $categoryOption)
                                    <option value="{{$categoryOption->id}}"
                                    @if($categoryOption->id == $item->category_id) selected @endif>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="slug">Identificator</label>
                            <input name="slug" value="{{$item->slug}}"
                                   id="slug"
                                   type="text"
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Excerpt</label>
                            <textarea name="excerpt"
                                      id="excerpt"
                                      class="form-control"
                                      rows="3">{{old('excerpt', $item->excerpt)}}</textarea>
                        </div>

                        <div class="form-check">
                            <input name="is_published"
                            type="hidden"
                            value="0">
                            <input name="is_published"
                                   type="checkbox"
                                   class="form-check-input"
                                   value="{{$item->is_published}}"
                                   @if($item->is_published)
                                       checked="checked"
                                   @endif>
                            <label class="form-check-label" for="is_published">Published</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
