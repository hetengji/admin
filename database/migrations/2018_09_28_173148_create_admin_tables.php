<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TODO 整理一步步删除 先注释
        //去除 安装
//        $connection = config('admin.database.connection') ?: config('database.default');

//        Schema::connection($connection)->create(config('admin.database.users_table'), function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('username', 190)->unique();
//            $table->string('password', 60);
//            $table->string('name');
//            $table->string('avatar')->nullable();
//            $table->string('remember_token', 100)->nullable();
//            $table->timestamps();
//        });
//
//        Schema::connection($connection)->create(config('admin.database.roles_table'), function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name', 50)->unique();
//            $table->string('slug', 50);
//            $table->timestamps();
//        });
//
//        Schema::connection($connection)->create(config('admin.database.permissions_table'), function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name', 50)->unique();
//            $table->string('slug', 50);
//            $table->string('http_method')->nullable();
//            $table->text('http_path')->nullable();
//            $table->timestamps();
//        });
//
//        Schema::connection($connection)->create(config('admin.database.menu_table'), function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('parent_id')->default(0);
//            $table->integer('order')->default(0);
//            $table->string('title', 50);
//            $table->string('icon', 50);
//            $table->string('uri', 50)->nullable();
//
//            $table->timestamps();
//        });
//
//        Schema::connection($connection)->create(config('admin.database.role_users_table'), function (Blueprint $table) {
//            $table->integer('role_id');
//            $table->integer('user_id');
//            $table->index(['role_id', 'user_id']);
//            $table->timestamps();
//        });
//
//        Schema::connection($connection)->create(config('admin.database.role_permissions_table'), function (Blueprint $table) {
//            $table->integer('role_id');
//            $table->integer('permission_id');
//            $table->index(['role_id', 'permission_id']);
//            $table->timestamps();
//        });
//
//        Schema::connection($connection)->create(config('admin.database.user_permissions_table'), function (Blueprint $table) {
//            $table->integer('user_id');
//            $table->integer('permission_id');
//            $table->index(['user_id', 'permission_id']);
//            $table->timestamps();
//        });
//
//        Schema::connection($connection)->create(config('admin.database.role_menu_table'), function (Blueprint $table) {
//            $table->integer('role_id');
//            $table->integer('menu_id');
//            $table->index(['role_id', 'menu_id']);
//            $table->timestamps();
//        });
//
//        Schema::connection($connection)->create(config('admin.database.operation_log_table'), function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('user_id');
//            $table->string('path');
//            $table->string('method', 10);
//            $table->string('ip');
//            $table->text('input');
//            $table->index('user_id');
//            $table->timestamps();
//        });
        // 题库相关数据库
        Schema::create('te_classifys', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('group_id')->default(0)->comment('组ID');
            $table->string('classify_name', 100)->default('')->comment('适用于区域的名称');
        });
        Schema::create('te_dimensions', function(Blueprint $table)
        {
            $table->increments('dimension_id');
            $table->string('name',100)->default('')->comment('维度名称');
            $table->timestamps();
        });
        Schema::create('te_subject_contacts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('subject_id')->default(0)->comment('试卷的ID');
            $table->integer('dimension_id')->default(0)->comment('维度ID');
            $table->integer('paper_id')->default(0)->comment('试卷ID');
        });
        Schema::create('te_subject_contents', function(Blueprint $table)
        {
            $table->increments('subject_content_id');
            $table->integer('subject_id')->default(0)->comment('题的ID');
            $table->boolean('content_type')->default(0)->comment('题的 选项分类: 文字 图片,音频等等');
            $table->string('content', 500)->default('')->comment('内容');
            $table->boolean('score')->default(0)->comment('分数');
            $table->string('remark', 500)->default('')->comment('备注');
            $table->integer('status')->default(0)->comment('是否允许 填空 0 不允许 填空  1 允许填空  2 允许填空且 必填 (内容在答案表中)');
            $table->timestamps();
        });
        Schema::create('te_subject_paper_sons', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('paper_id')->default(0)->comment('父级ID 试卷ID ');
            $table->integer('subject_id')->default(0)->comment('问题的ID');
            $table->boolean('is_must')->default(1)->comment('是否必填项 是=1 否=0');
        });
        Schema::create('te_subject_papers', function(Blueprint $table)
        {
            $table->increments('paper_id');
            $table->string('name',255)->default('')->comment('试卷名称');
            $table->integer('company_id')->default(0)->comment('公司ID  0 代表通用模板');
            $table->integer('make_subject_user_id');
            $table->string('scoring_rules',255)->comment('试卷的计分规则');
            $table->timestamps();
        });
        Schema::create('te_subjects', function(Blueprint $table)
        {
            $table->increments('subject_id', true)->comment('自增ID');
            $table->integer('company_id')->unsigned()->default(0)->comment('公司ID 默认值为 0 表示公开的  存在数值表示对应私有的值');
            $table->string('title', 500)->default('')->comment('题目的名称');
            $table->string('remark',255)->default('')->comment('备注');
            $table->boolean('is_required')->default(1)->comment('是否必填');
            $table->boolean('type')->default(0)->comment('题型: 指的是 单选多选的属性');
            $table->boolean('status')->default(0)->comment('是否取反 0=正常  1=取反');
            $table->integer('group_id')->default(0)->comment('组别ID适用于成套题目 0 表示不存在');
            $table->boolean('content_type')->default(0)->comment('题的 选项分类: 文字 图片,音频等等');
            $table->boolean('classify_id')->default(0)->comment('适用于的行业 暂时只有一种 | 关联 te_classify表中ID');
            $table->timestamps();
        });
        Schema::create('te_subject_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 100)->default('')->comment('名称');
            $table->text('config', 65535)->comment('类型的配置信息 序列化 或者 json');
            $table->boolean('status')->default(1)->comment('状态是否显示 是=1 | 否=0');
        });
        Schema::create('te_user_answers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('teach_answer_id')->default(0)->comment('用户ID');
            $table->integer('company_id')->default(0)->comment('公司ID');
            $table->integer('paper_id')->default(0)->comment('试卷的ID');
            $table->text('answer_details', 65535)->comment('答案详情 序列化 存储');
            $table->integer('time')->default(0)->comment('用时长度');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        Schema::connection($connection)->dropIfExists(config('admin.database.users_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.roles_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.permissions_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.menu_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_permissions_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.role_users_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.role_permissions_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.role_menu_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.operation_log_table'));
    }
}
