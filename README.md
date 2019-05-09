Selecty extension for laravel-admin
======

这是个select的功能扩展，此扩展是在官方select控件的基础上扩展的自定义功能`laravel-admin`扩展。

### 由来
> 由于在特定场景下使用select控件的时候遇到$from在编辑状态下的时候无法自动选中select项。

### 问题
> 如果select选择框的关联数据没有在当前数据表记录的话，就无法选中。例如有数据表关联如下情况： <br>
D表关联C表<br>
C表关联B表<br>
B表关联A表<br>
那么在D表中调用 C的数据没问题应该D表有字段关联了C表，
但是A,B就无法得知其关联的关系。

### 解决
> 给select加了个选项让其知道该去选中哪个目标


## 安装

```bash
composer require laravel-admin-exts/selecty
```

## 配置

在`config/admin.php`文件的`extensions`，加上属于这个扩展的一些配置
```php
    'extensions' => [

        'selecty' => [
            // 如果要关掉这个扩展，设置为false
            'enable' => true,
            // 编辑器的配置
            'config' => [
            ]
        ]

    ]
```

## 使用

三级联动 使用例子：
```php
$form->selecty('school_id', '学校')
->options(function (){
    return School::pluck('school_name', 'id');
})
->target(function (){ 
    //这里使用target 传入ID 让控件选中指定的值 
    //$this->id 是为了兼容创建页面，因为创建页面没有当前模型对象 如果不判断会报错
    //load 实际就是官方的功能 可以看官方文档
    if($this->id) return $this->course->grade->school->id;
})
->load('grade_id', '/admin/api/grade');

$form->selecty('grade_id', '班级')
->options(function (){
    if($this->id){
        return Grade::where('school_id', $this->course->grade->school->id)
            ->pluck('grade_name', 'id');
    }
})
->target(function (){
    //这里使用target 传入ID 让控件选中指定的值
    if($this->id) return $this->course->grade->id;
})
->load('course_id', '/admin/api/course');

$form->selecty('course_id', '课程')
->options(function (){
    if($this->id) {
        return Course::where('grade_id', $this->course->grade->id)
        ->pluck('course_name', 'id');
    }
});
```
## 文档
其他功能与用法参考官方文档：[http://laravel-admin.org/docs/zh/model-form-fields#select%E9%80%89%E6%8B%A9%E6%A1%86](http://laravel-admin.org/docs/zh/model-form-fields#select%E9%80%89%E6%8B%A9%E6%A1%86)

## 支持

就是小功能而已，觉得帮到你了的话 点个小星星:)，也欢迎提功能以便改进
