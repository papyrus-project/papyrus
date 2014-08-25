<?php
class BookUpdateCommand extends CConsoleCommand{
	public function run(){
		$command = Yii::app()->db->createCommand('
			SELECT *
			FROM `alex`.`books`
			WHERE status = "0"');
		$reader = $command->query();
		foreach ($reader as $row) {
			
			print($row['id'].PHP_EOL);
			$command = 'ebook-convert /var/www/upload/pdf/'.$row['id'].'.pdf /var/www/upload/pdf/'.$row['id'].'.mobi';
			print_r($command.PHP_EOL);
			exec($command);
			$command = 'ebook-convert /var/www/upload/pdf/'.$row['id'].'.pdf /var/www/upload/pdf/'.$row['id'].'.epub';
			print_r($command.PHP_EOL);
			exec($command);
			
			$command = Yii::app()->db->createCommand('
				UPDATE books
				SET
					status = "1"
				WHERE id = "'.$row['id'].'"');
			$command->execute();
			
			//exec('calibredb add --with-library=/var/www/lib /var/www/upload/26.pdf --authors='.$row['author'].' --title='.$row['title'].' --tags=6');
			
			/*
			calibredb add --with-library=/var/www/lib [Buchpfad] --authors=[Autor] --title=[Titel] --tags=[UDID_DB_YII]

			calibredb list --with-library=/var/www/lib --separator=";" --fields=*pages,*words,Authors,title,tags --search=[UDID_DB_YII]
			
			
			calibredb add --with-library=/var/www/lib /var/www/Typo-Termine,_Aufgabe,_Abgabe.pdf --authors=Loh --title=Typo --tags=1
			
			
			calibredb list --with-library=/var/www/lib --separator=";" --fields=*pages,*words,Authors,title,tags --search=1
			*/
		}
	}
}
