<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 2018/9/30
 * Time: 9:57
 */

namespace Evaluation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table='te_subjects';
    protected $primaryKey='subject_id';


    /**
     * Notes: 关联 题的 内容表 一对多关系
     * author 何腾骥
     * Date: 2018/10/8
     * Time: 9:58
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjectContents()
    {
        return $this->hasMany('Evaluation\Admin\Models\subjectContent','subject_id','subject_id');
    }


}
