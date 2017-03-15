<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Nodes;

/**
 * NodesSearch represents the model behind the search form about `backend\models\Nodes`.
 */
class NodesSearch extends Nodes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nodeid', 'pid', 'listorder', 'display',], 'integer'],
            [['title', 'm', 'c', 'a', 'data', 'img_icon',], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Nodes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'nodeid' => $this->nodeid,
            'pid' => $this->pid,
            'listorder' => $this->listorder,
            'display' => $this->display,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'm', $this->m])
            ->andFilterWhere(['like', 'c', $this->c])
            ->andFilterWhere(['like', 'a', $this->a])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
