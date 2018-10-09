<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 2018/9/30
 * Time: 16:25
 */

namespace Evaluation\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $table='te_user_answers';
    protected $primaryKey='id';

    /**
     * Notes: 关联 试卷表
     * author 何腾骥
     * Date: 2018/10/8
     * Time: 12:01
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function papers()
    {
        return $this->belongsTo('Evaluation\Admin\Models\SubjectPaper', 'paper_id', 'paper_id');
    }
}
