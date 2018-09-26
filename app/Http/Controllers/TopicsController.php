<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
//        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

/*	public function index()
	{
//		$topics = Topic::paginate();
		$topics = Topic::with('user','category')->paginate(30);
		return view('topics.index', compact('topics'));
	}*/
    public function index(Request $request, Topic $topic,User $user,Link $link)
    {

        $topics = $topic->withOrder($request->order)->paginate(20);
        $active_users = $user->getActiveUsers();
//        dd($active_users);
        $links = $link->getAllCached();
//        dd($links);

        return view('topics.index', compact('topics', 'active_users','links'));
    }

    public function show(Request $request,Topic $topic)
    {

        // URL 矫正

        /*当话题有 Slug 的时候，我们希望用户一直使用正确的、带着 Slug 的链接来访问。
        我们可以在控制器中对 Slug 进行判断，当条件允许的时候，我们将发送 301 永久重定向指令给浏览器，跳转到带 Slug 的链接：*/
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        /*注意此处使用 Laravel 的 『隐性路由模型绑定』 功能，
        当请求 http://larabbs.test/topics/1 时，$topic 变量会自动解析为 ID 为 1 的帖子对象。*/
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	/*public function store(TopicRequest $request)
	{
		$topic = Topic::create($request->all());
		return redirect()->to($topic->link())->with('message', 'Created successfully.');
	}*/
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

//        return redirect()->to($topic->link())->with('success', '成功创建话题。');
        return redirect()->to($topic->link())->with('success', '成功创建话题！');
    }

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '更新成功。');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '删除成功。');
	}

	/*上传图片*/
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}