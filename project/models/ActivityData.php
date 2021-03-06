<?php

namespace project\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%activity_data}}".
 *
 * @property int $id
 * @property int $corporation_id
 * @property int $statistics_time
 * @property int $projectman_usercount
 * @property int $projectman_projectcount
 * @property int $projectman_membercount
 * @property int $projectman_versioncount
 * @property int $projectman_issuecount
 * @property double $projectman_storagecount
 * @property int $codehub_all_usercount
 * @property int $codehub_repositorycount
 * @property int $codehub_commitcount
 * @property double $codehub_repositorysize
 * @property int $pipeline_usercount
 * @property int $pipeline_pipecount
 * @property int $pipeline_executecount
 * @property double $pipeline_elapse_time
 * @property int $codecheck_usercount
 * @property int $codecheck_taskcount
 * @property int $codecheck_codelinecount
 * @property int $codecheck_issuecount
 * @property int $codecheck_execount
 * @property int $codeci_usercount
 * @property int $codeci_buildcount
 * @property int $codeci_allbuildcount
 * @property double $codeci_buildtotaltime
 * @property int $testman_usercount
 * @property int $testman_casecount
 * @property int $testman_totalexecasecount
 * @property int $deploy_usercount
 * @property int $deploy_envcount
 * @property int $deploy_execount
 * @property double $deploy_vmcount
 *
 * @property Corporation $corporation
 */
class ActivityData extends \yii\db\ActiveRecord
{
    
    const MEAL_D = 0;
    const MEAL_N = -1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id','corporation_id', 'statistics_time'], 'required'],
            [['group_id','corporation_id', 'statistics_time','devcloud_pv','projectman_projectcount', 'projectman_membercount', 'projectman_issuecount','projectman_wiki','projectman_docman', 'codehub_repositorycount', 'codehub_commitcount','pipeline_assignmentscount','codecheck_taskcount', 'codecheck_codelinecount','codecheck_execount','codeci_buildcount','testman_casecount','testman_execasecount', 'deploy_envcount', 'deploy_execount','releaseman_uploadcount','releaseman_downloadcount', 'projectman_usercount', 'projectman_versioncount', 'codehub_all_usercount', 'pipeline_usercount', 'pipeline_pipecount', 'pipeline_executecount', 'codecheck_usercount',  'codecheck_issuecount',  'codeci_usercount',  'codeci_allbuildcount', 'testman_usercount',  'testman_totalexecasecount', 'deploy_usercount'], 'integer'],
            [['codehub_repositorysize', 'pipeline_elapse_time', 'codeci_buildtotaltime','projectman_storagecount',  'deploy_vmcount'], 'number'],            
            [['corporation_id', 'statistics_time'], 'unique', 'targetAttribute' => ['corporation_id', 'statistics_time'],'message'=>'已经存在此项数据'], 
            [['corporation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corporation::className(), 'targetAttribute' => ['corporation_id' => 'id']],
            [[ 'devcloud_pv','projectman_projectcount', 'projectman_membercount', 'projectman_issuecount','projectman_wiki','projectman_docman', 'codehub_repositorycount', 'codehub_commitcount','pipeline_assignmentscount','codecheck_taskcount', 'codecheck_codelinecount','codecheck_execount','codeci_buildcount','testman_casecount','testman_execasecount', 'deploy_envcount', 'deploy_execount','releaseman_uploadcount','releaseman_downloadcount', 'projectman_usercount', 'projectman_versioncount', 'codehub_all_usercount', 'pipeline_usercount', 'pipeline_pipecount', 'pipeline_executecount', 'codecheck_usercount',  'codecheck_issuecount',  'codeci_usercount',  'codeci_allbuildcount', 'testman_usercount',  'testman_totalexecasecount', 'deploy_usercount','codehub_repositorysize', 'pipeline_elapse_time', 'codeci_buildtotaltime','projectman_storagecount',  'deploy_vmcount',],'default','value'=>0]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge([
            'id' => 'ID',
            'group_id' => '项目',
            'corporation_id' => '公司',
            'statistics_time' => '统计时间',
            ],
            ActivityChange::$List['column_activity']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporation()
    {
        return $this->hasOne(Corporation::className(), ['id' => 'corporation_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
    
    public static function get_code($all=true) {
//       $table = self::tableName();
//       $tableSchema = Yii::$app->db->schema->getTableSchema($table);
//       $fields = ArrayHelper::getColumn($tableSchema->columns, 'name', 'name');
//       unset($fields['id']);
//       unset($fields['corporation_id']);
//       unset($fields['statistics_time']);
        $fields= ActivityChange::$List['column_activity'];
    
        return $all?array_merge(['huawei_account'=>'华为云账号','corporation_name'=>'企业名称'],$fields):$fields;
    }
    
     public static function get_code_name($code) {

        $fields= array_merge(['huawei_account'=>'华为云账号','corporation_name'=>'企业名称'], ActivityChange::$List['column_activity']);
    
        return isset($fields[$code])?$fields[$code]:'';
    }
        
    public static function get_corporationid_by_time($statistics_time='',$group_id=null) {   
       return static::find()->andFilterWhere(['statistics_time'=>$statistics_time,'group_id'=>$group_id])->select(['corporation_id'])->column();

    }
    
    public static function get_pre_time($statistics_time='',$group_id=null,$corporation_id='') {   
       return static::find()->andFilterWhere(['<','statistics_time',$statistics_time])->andFilterWhere(['corporation_id'=>$corporation_id,'group_id'=>$group_id])->select(['statistics_time'])->orderBy(['statistics_time'=>SORT_DESC])->distinct()->scalar();

    }
    
    public static function get_next_time($statistics_time='',$group_id=null,$corporation_id='') {   
       return static::find()->andFilterWhere(['>','statistics_time',$statistics_time])->andFilterWhere(['corporation_id'=>$corporation_id,'group_id'=>$group_id])->select(['statistics_time'])->orderBy(['statistics_time'=>SORT_ASC])->distinct()->scalar();

    }
    
    public static function get_data_by_time($statistics_time='',$group_id=null) {   
       return static::find()->where(['statistics_time'=>$statistics_time])->andFilterWhere(['group_id'=>$group_id])->indexBy(['corporation_id'])->asArray()->all();
    }
    
    public static function get_member_by_time($statistics_time,$corporation_id) {   
       return static::find()->where(['corporation_id'=>$corporation_id])->andWhere(['<=','statistics_time',$statistics_time])->orderBy(['statistics_time'=>SORT_DESC])->limit(1)->select(['projectman_membercount'])->scalar();
    }
    
    
    
    public static function get_user_total($start, $end,$total=1,$annual='',$group_id=null,$allocate=null) {
              
        $query = static::find()->alias('d')->andWhere(['d.group_id'=>$group_id])->andFilterWhere(['and',['>=', 'statistics_time', $start],['<=', 'statistics_time', $end]]);
        if($annual=='all'){         
            
        }elseif($annual){
            $corporation_id= CorporationMeal::find()->where(['annual'=>$annual])->select(['corporation_id'])->distinct()->column();
            $query->andFilterWhere(['d.corporation_id'=>$corporation_id]);
        }
        if($allocate){
            $query->leftJoin(['m'=>CorporationMeal::tableName()],'m.corporation_id=d.corporation_id AND d.statistics_time>=m.start_time AND d.statistics_time<=m.end_time')->andWhere(['>','m.devcloud_count',0]);  
        }else{
            $ids= static::find()->alias('a')->andWhere(['a.group_id'=>$group_id])->andWhere(['not exists', CorporationMeal::find()->alias('b')->where('b.corporation_id=a.corporation_id AND a.statistics_time>=b.start_time AND a.statistics_time<=b.end_time')])->select(['id'])->column();
            $query->leftJoin(['m'=>CorporationMeal::tableName()],['and','m.corporation_id=d.corporation_id',['or',['and','d.statistics_time>=m.start_time','d.statistics_time<=m.end_time',['not in','d.id',$ids]],['and',['in','d.id',$ids],['not exists', CorporationMeal::find()->alias('b')->where('b.corporation_id=m.corporation_id AND b.end_time>m.end_time')]]]]);
        }
        $query->orderBy(['statistics_time'=>SORT_ASC])->groupBy(['statistics_time']);
        $query->select(['statistics_time','user_num'=>'SUM(projectman_membercount)','total_num'=>'SUM(devcloud_count)']);
        
        if(!$total){
            $query->leftJoin(['bd'=> CorporationBd::tableName()],['and','bd.corporation_id=d.corporation_id',['not exists', CorporationBd::find()->alias('bd2')->where('bd2.corporation_id=bd.corporation_id AND bd2.start_time>bd.start_time AND d.statistics_time>=bd.start_time')]])->addGroupBy(['bd_id'])->addSelect(['bd_id']);
        }
        return $query->asArray()->all();
    }
}
