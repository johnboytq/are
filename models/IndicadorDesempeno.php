<?php

/**********
Versión: 001
Fecha: 14-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Indicadores de desempeno
---------------------------------------
Modificaciones:
Fecha: 14-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - en los label ortografia
---------------------------------------
Modificaciones:
Fecha: 04-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agrega el campo codigo
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicador_desempeno".
 *
 * @property string $id
 * @property string $descripcion
 * @property integer $codigo
 *
 * @property AsignacionesXIndicadorDesempeno[] $asignacionesXIndicadorDesempenos
 */
class IndicadorDesempeno extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'indicador_desempeno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string', 'max' => 100],
            [['codigo'], 'number'],
			[['codigo','descripcion'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'descripcion' => 'Descripción',
            'codigo' => 'Código',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignacionesXIndicadorDesempenos()
    {
        return $this->hasMany(AsignacionesXIndicadorDesempeno::className(), ['id_indicador_desempeno' => 'id']);
    }
}
