-Создать в домашней директории директорию homeWork2
mkdir homeWork2

-Создать файл index.html внутри директории homeWork2
touch newContent/index.html  

-Создать внутри директории homeWork2 директорию content
cd homeWork2/
mkdir content

-Скопировать файл index.html в директорию content
cp index.html content/index.html 

-Создать внутри директории homeWork2 директорию newContent
mkdir newContent

-Переместить файл index.html из директории content в директорию newContent
cd content
cv index.html ../newContent           

-Удалить директорию content
cd ../
rmdir content   

-Переименовать файл index.html на newIndex.html
mv index.html newIndex.html  

-Изменить права доступа для файла newIndex.html: Только пользователь имеет право читать записывать и выполнять, группа имеет только права на чтение, а остальные не имеют никаких прав
chmod 740 newIndex.html 