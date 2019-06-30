<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ParticipateInConference[] $participateInConferences
 * @property PatentDocuments[] $patentDocuments
 * @property ScientificPublications[] $scientificPublications
 * @property TeacherStatus[] $teacherStatuses
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'password', 'authKey', 'accessToken'], 'string', 'max' => 100],
            [['name', 'surname', 'patronymic'], 'string', 'max' => 25],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'name' => 'Name',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipateInConferences()
    {
        return $this->hasMany(ParticipateInConference::className(), ['idUser' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatentDocuments()
    {
        return $this->hasMany(PatentDocuments::className(), ['idUser' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScientificPublications()
    {
        return $this->hasMany(ScientificPublications::className(), ['idUser' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherStatuses()
    {
        return $this->hasMany(TeacherStatus::className(), ['idUser' => 'id']);
    }
}
