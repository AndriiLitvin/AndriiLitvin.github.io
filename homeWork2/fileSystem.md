- Создать в домашней директории директорию homeWork2<br>
mkdir homeWork2

- Создать файл index.html внутри директории homeWork2<br>
touch newContent/index.html  

- Создать внутри директории homeWork2 директорию content<br>
cd homeWork2/<br>
mkdir content

- Скопировать файл index.html в директорию content<br>
cp index.html content/index.html 

- Создать внутри директории homeWork2 директорию newContent<br>
mkdir newContent

- Переместить файл index.html из директории content в директорию newContent<br>
cd content<br>
cv index.html ../newContent           

- Удалить директорию content<br>
cd ../<br>
rmdir content   

- Переименовать файл index.html на newIndex.html<br>
mv index.html newIndex.html  

- Изменить права доступа для файла newIndex.html: Только пользователь имеет право читать записывать и выполнять, группа имеет только права на чтение, а остальные не имеют никаких прав<br>
chmod 740 newIndex.html 