@extends('admin/common/master')
@section('title','主页')
@section('class','')
@section('content')
<!-- layout admin -->
<div class="layui-layout layui-layout-admin"> <!-- 添加skin-1类可手动修改主题为纯白，添加skin-2类可手动修改主题为蓝白 -->
    <!-- header -->
    <div class="layui-header my-header">
        <a href="{{url('/index/index')}}">
           
            <div class="my-header-logo"> 电销管理后台 &nbsp;&nbsp;&nbsp;</div>
        </a>
        <div class="my-header-btn">
            <button class="layui-btn layui-btn-small btn-nav"><i class="layui-icon">&#xe65f;</i></button>
        </div>

        <!-- 顶部右侧添加选项卡监听 -->
        <ul class="layui-nav my-header-user-nav" lay-filter="side-top-right">
            <li class="layui-nav-item"><a href="javascript:;" class="pay" href-url="">支持作者</a></li>
            <li class="layui-nav-item">
                <a class="name" href="javascript:;"><i class="layui-icon">&#xe629;</i>主题</a>
                <dl class="layui-nav-child">
                    <dd data-skin="0"><a href="javascript:;">默认</a></dd>
                    <dd data-skin="1"><a href="javascript:;">纯白</a></dd>
                    <dd data-skin="2"><a href="javascript:;">蓝白</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a class="name" href="javascript:;">&nbsp;&nbsp; {{\Auth::guard('back')->user()->mg_name}} </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" id="password"><i class="layui-icon">&#xe620;</i>密码重置</a></dd>
                    <dd><a href="{{url('/logout')}}"><i class="layui-icon">&#x1006;</i>退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <!-- side -->
    <div class="layui-side my-side">
        <div class="layui-side-scroll">
            <!-- 左侧主菜单添加选项卡监听 -->
            <ul class="layui-nav layui-nav-tree" lay-filter="side-main">
                @foreach($permissoin_0 as $v)
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon">{{$v->icon}}</i>{{$v->p_name}}</a>
                    <dl class="layui-nav-child">
                        @foreach($permissoin_1 as $vv)
                        @if($vv->ps_pid == $v->p_id)
                        <dd><a href="javascript:;" href-url="{{url($vv->ps_route)}}">
                            <i class="layui-icon">&#xe621;</i>{{$vv->p_name}}</a>
                        </dd>
                        @endif
                        @endforeach
                    </dl>
                </li>
                @endforeach
            </ul>

        </div>
    </div>
    <!-- body -->
    <div class="layui-body my-body">
        <div class="layui-tab layui-tab-card my-tab" lay-filter="card" lay-allowClose="true">
            <ul class="layui-tab-title">
                <li class="layui-this" lay-id="1"><span><i class="layui-icon">&#xe638;</i>欢迎页</span></li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe id="iframe" src="{{url('welcome')}}" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <div class="layui-footer my-footer">
        
    </div>
</div>

<!-- pay -->
<div class="my-pay-box none">
    <div><img src="/admin/frame/static/image/zfb.png" alt="支付宝"><p>支付宝</p></div>
</div>

<!-- 右键菜单 -->
<div class="my-dblclick-box none">
    <table class="layui-tab dblclick-tab">
        <tr class="card-refresh">
            <td><i class="layui-icon">&#x1002;</i>刷新当前标签</td>
        </tr>
        <tr class="card-close">
            <td><i class="layui-icon">&#x1006;</i>关闭当前标签</td>
        </tr>
        <tr class="card-close-all">
            <td><i class="layui-icon">&#x1006;</i>关闭所有标签</td>
        </tr>
    </table>
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/frame/static/js/vip_comm.js"></script>
<script type="text/javascript">
layui.use(['layer'], function () {

    // 操作对象
    var layer       = layui.layer
        ,$          = layui.jquery;

    $('#password').click(function(){
        layer.open({
          type: 2,
          title: '密码处理',
          shadeClose: true,
          shade: 0.8,
          area: ['628px', '428px'],
          content: '{{url("/password")}}' //iframe的url
        }); 
    })
});
</script>
@endsection