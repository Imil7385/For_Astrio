<?php
//Array_start
$categories = array(
	array(
   	"id" => 1,
   	"title" =>  "Обувь",
   	'children' => array(
       	array(
           	'id' => 2,
           	'title' => 'Ботинки',
           	'children' => array(
               	array('id' => 3, 'title' => 'Кожа'),
               	array('id' => 4, 'title' => 'Текстиль'),
           	),
       	),
       	array('id' => 5, 'title' => 'Кроссовки'),
   	)
	),
	array(
   	"id" => 6,
   	"title" =>  "Спорт",
   	'children' => array(
       	array(
           	'id' => 7,
           	'title' => 'Мячи'
       	)
   	)
	),
);
//Array_end


function searchCategory($categories,$id){
		for ($i=0; $i < count($categories); $i++) {
				if ($categories[$i]['id']==$id) {
						return $categories[$i]['title']."</br>";
						break;
				};
				for ($j=0; $j < count($categories[$i]['children'][0]); $j++) {
						if ($categories[$i]['children'][$j]['id']==$id) {
								return $categories[$i]['children'][$j]['title']."</br>";
								break;
						};
						for ($n=0; $n < @count($categories[$i]['children'][$j]['children'][0]); $n++) {
								if ($categories[$i]['children'][$j]['children'][$n]['id']==$id) {
										return $categories[$i]['children'][$j]['children'][$n]['title']."</br>";
										break;
								};
						}
				}
		}
};
echo searchCategory($categories,7);
 ?>
