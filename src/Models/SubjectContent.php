<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 2018/9/30
 * Time: 15:53
 */

namespace Evaluation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class SubjectContent extends Model
{
    protected $table='te_subject_contents';
    protected $primaryKey='te_subject_content_id';

    /**
     * Notes: 关联属于 试卷表
     * author 何腾骥
     * Date: 2018/10/8
     * Time: 10:04
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo('Evaluation\Admin\Models\Subject','subject_id','subject_id');
    }

}
