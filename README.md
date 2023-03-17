
# Объектно-ориентированная реализация клиента Sentry

Поддерживает:
* смену `DSN`
* установку тегов
* установку уровня строгости проблемы
* установку пользователя/клиента затронутого проблемой
* добавление `breadcrumbs` - событий, которые привели к проблеме
* захват и передачу в Sentry исключения или сообщения

> Передача информации в Sentry осуществляется только в момент захвата (`capture` методы), поэтому обогащать проблему данными необходимо до захвата.