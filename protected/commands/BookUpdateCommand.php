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
		}
	}
}
