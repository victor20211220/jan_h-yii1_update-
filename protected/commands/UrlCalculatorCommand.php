<?php
class UrlCalculatorCommand extends CConsoleCommand {
    public function actionIndex() {
        UrlCounter::model()->truncateTable();

        $roots = Category::model() -> roots() -> findAll();
        foreach($roots as $root) {
            $descendants=$root->descendants()->findAll();
            foreach($descendants as $descendant) {
                $des = $descendant->descendants()->findAll();
                $cat_ids = array();
                $cat_ids[]=$descendant->id;
                foreach($des as $d) {
                    $cat_ids[] = $d->id;
                }
                $total = Yii::app()->db->createCommand()
                    -> select("count(*) as cnt")
                    -> from("{{website}}")
                    -> where(
                       array('and', array('and', 'status=:status', 'lang_id=:lang_id'), array('in', 'category_id', $cat_ids)),
                       array(':lang_id'=>$root->lang_id, ':status'=>Website::STATUS_APPROVED)
                    )
                    -> queryScalar();

                if($total == 0) {
                    continue;
                }

                $counter = new UrlCounter();
                $counter -> category_id = $descendant->id;
                $counter -> website_count = $total;
                $counter -> save(false);
            }
        }
        Yii::app()->cache->flush();
        return true;
    }
}