<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 2018/9/30
 * Time: 16:02
 */

namespace App\Evaluation\admin\src\Models;


use Illuminate\Database\Eloquent\Model;

class SubjectPaper extends Model
{
    protected $table='te_subject_papers';
    protected $primaryKey='paper_id';


    /**
     * Notes: 远层一对多 通过中间表 维度--试卷---题 关联  可以通过 找到相对应的题
     * author 何腾骥
     * Date: 2018/10/8
     * Time: 11:50
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function subject(){

        return $this->hasManyThrough(
            'Evaluation\Admin\Models\Subject',
            'Evaluation\Admin\Models\SubjectContact',
            'subject_id', // 中间表的外键
            'subject_id', // 试卷表的外键
            'subject_id', // 题目标题表本地键...
            'id' // 维度--试卷---题  关联表 本地键...
        );
    }

    /**
     * Notes: 关联多个的 提交测评答案 user_answers
     * author 何腾骥
     * Date: 2018/10/8
     * Time: 11:54
     */
    public function papers()
    {
        $this->hasMany('Evaluation\Admin\Models\UserAnswer', 'paper_id', 'paper_id');
    }


}
