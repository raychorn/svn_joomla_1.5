﻿<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007 by Bernard Gilly        *
* --------- All Rights Reserved ------------ *
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.6                         *
* License    : Creative Commons              *
* Перевод    : Dark Preacher                 *
*              dark4832 [at] mail [dot] ru   *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Прямой доступ к этому файлу запрещён.' );

DEFINE("_MXC_CPL_CONFIG","Конфигурация");
DEFINE("_MXC_CPL_ADM_COMMENTS","Коментарии автора");
DEFINE("_MXC_CPL_USER_COMMENTS","Комментарии пользователей");
DEFINE("_MXC_CPL_FAVOURED","Одобренное");
DEFINE("_MXC_CPL_EDIT_CSS_FILE","Редактировать CSS");
DEFINE("_MXC_CPL_EDIT_LANGUAGE_FILE","Редактировать перевод");
DEFINE("_MXC_CPL_BAD_WORDS","Управление цензурой");
DEFINE("_MXC_CPL_SUPPORT_WEBSITE","Сайт поддержки");
DEFINE("_MXC_CPL_ABOUT","О компоненте");
DEFINE("_MXC_MSG_IMPORT_SUCCESS","Импорт AkoComment Tweaked Special Edition прошло успешно!");
DEFINE("_MXC_MSG_IMPORT_ERROR","Ошибка импорта AkoComment Tweaked Special Edition !");
DEFINE("_MXC_CONTROLPANEL","Контрольная панель");
DEFINE("_MXC_COMMENTS","Комментарии");
DEFINE("_MXC_COMMENT","Комментарий");
DEFINE("_MXC_EDIT","Правка");
DEFINE("_MXC_FILTER","Фильтр");
DEFINE("_MXC_AUTHOR","Автор");
DEFINE("_MXC_AUTHORARTICLE","Автор статьи");
DEFINE("_MXC_DATE","Дата");
DEFINE("_MXC_IP","IP");
DEFINE("_MXC_CONTENT_ITEM","Статья");
DEFINE("_MXC_PUBLISHED","Публикация");
DEFINE("_MXC_CLOSE","Закрыть");
DEFINE("_MXC_CANCEL","Отмена");
DEFINE("_MXC_SAVE","Сохранить");
DEFINE("_MXC_NEW","Новый");
DEFINE("_MXC_NONE","Нет");
DEFINE("_MXC_RATING","Оценка");
DEFINE("_MXC_NO_RATING","Нет оценки");
DEFINE("_MXC_LEVEL_RATING","Уровень оценки");
DEFINE("_MXC_ORDERING","Сортировка");
DEFINE("_MXC_TITLE","Заголовок");
DEFINE("_MXC_ADD","Добавить");
DEFINE("_MXC_DETAILS","Детали");
DEFINE("_MXC_PREVIEW_ARTICLE","Предварительный просмотр статьи");
DEFINE("_MXC_ITEM_DELETED","Удалено");
DEFINE("_MXC_ITEM_SAVED","Сохранено");
DEFINE("_MXC_LANGUAGE_SAVED","Файл перевода сохранён");
DEFINE("_MXC_FILE_NOT_WRITEABLE","Невозможно сохранить файл!");
DEFINE("_MXC_FILE_MUST_BE_WRITEABLE","Файл должен быть доступен для записи, чтобы сохранить ваши изменения.");
DEFINE("_MXC_WARNING","Предупреждение...");
DEFINE("_MXC_EDIT_LANGUAGE","Редактировать файл перевода");
DEFINE("_MXC_EDIT_CSS","Редактировать файл CSS");
DEFINE("_MXC_CSS_SAVED","Файл CSS сохранён");
DEFINE("_MXC_EDITORSCOMMENTS","Комментарии автора");
DEFINE("_MXC_USERSCOMMENTS","Комментарии пользователей");
DEFINE("_MXC_EDITORSRATING","Оценка автора");
DEFINE("_MXC_USERSRATING","Оценка пользователей (для зарегистрированных)");
DEFINE("_MXC_FAVOURED","Одобрение");
DEFINE("_MXC_FAVORITES","Избранное");
DEFINE("_MXC_BADWORDS","Мат/ругань");
DEFINE("_MXC_BADWORD","Плохое слово");
DEFINE("_MXC_SETTINGS_SAVED","Настройки сохранены");
DEFINE("_MXC_NUM_CHARCARTERS","Доступные символы:");
DEFINE("_MXC_RESET","Сбросить");
DEFINE("_MXC_RESET_FAVOURED_COUNT","Сбросить счётчик одобрений");
DEFINE("_MXC_COUNTER_RESETED","Счётчик сброшен");
DEFINE("_MXC_MOSTPOPULAR","Самые популярные");
DEFINE("_MXC_LASTCOMMENTS","Последние");
DEFINE("_MXC_MOSTFAVOURED","Одобренные");
DEFINE("_MXC_CURRENTSETTINGS","Текущие установки");
DEFINE("_MXC_EXPLANATION","Описание");
DEFINE("_MXC_GENERAL","Основное");
DEFINE("_MXC_MAINOPERATINGMODE","Режим работы");
DEFINE("_MXC_MANUAL","Ручной");
DEFINE("_MXC_SEMIAUTOMATIC","Полу-автомат");
DEFINE("_MXC_AUTOMATIC","Автоматический");
DEFINE("_MXC_EXPL_MANUAL","В ручном режиме вы можете выбирать к каким статьям пользователи могут добавлять комментарии с помощью бот-команды <font color='green'>{mxc}</font>. Запретить комментирование можно с помощью бот-команды <font color='green'>{mxc::closed}</font>.");
DEFINE("_MXC_SECTIONSAVAILABLE","Доступные секции");
DEFINE("_MXC_EXPL_AUTOMATIC","Если вы выбрали полу-автоматический или автоматический режим, вы можете выбрать к статьям в каких секциях пользователи смогут добавлять комментарии. Можно выбрать несколько секций. Запретить комментирование можно с помощью бот-команды <font color='green'>{mxc::closed}</font>.");
DEFINE("_MXC_COMMENTFORM","Отображение комментариев");
DEFINE("_MXC_EXPL_COMMENTFORM","Выберите где будут отображены комментарии");
DEFINE("_MXC_OPENINSAMEWINDOW","В окне статьи");
DEFINE("_MXC_OPENINPOPUPWINDOW","Во всплывающем окне");
DEFINE("_MXC_WIDTH_POPUP","Ширина всплывающего окна");
DEFINE("_MXC_HEIGHT_POPUP","Высота всплывающего окна");
DEFINE("_MXC_EXPL_WIDTH_POPUP","Если вы выбрали отображение во всплывающем окне - введите ширину всплывающего окна");
DEFINE("_MXC_EXPL_HEIGHT_POPUP","Если вы выбрали отображение во всплывающем окне - введите высоту всплывающего окна");
DEFINE("_MXC_AUTOPUBLICHCOMMENTS","Авто-публикация комментариев");
DEFINE("_MXC_EXPL_AUTOPUBLICHCOMMENTS","Если Да - новые комментарии будут опубликованы автоматически");
DEFINE("_MXC_ANONYMOUSCOMMENTS","Анонимные комментарии");
DEFINE("_MXC_EXPL_ANONYMOUSCOMMENTS","Если Да - посетители (гости) смогут добавлять комментарии");
DEFINE("_MXC_REPORTCOMMENT","Уведомление о комментарии");
DEFINE("_MXC_EXPL_REPORTCOMMENT","Если Да - пользователи смогут уведомлять администратора о неприемлемом комментарии по электронной почте (пожаловаться на комментарий)");
DEFINE("_MXC_REPLYCOMMENT","Ответ на комментарий");
DEFINE("_MXC_EXPL_REPLYCOMMENT","Если Да - будет доступна функция ответа на комментарии");
DEFINE("_MXC_SHOWNAMEORUSERNAME","Показывать Имя или Ник?");
DEFINE("_MXC_NAME","Имя");
DEFINE("_MXC_USERNAME","Ник");
DEFINE("_MXC_EXPL_SHOWNAMEORUSERNAME","Только для зарегистрированных пользователей");
DEFINE("_MXC_USEMAXCOMMENTONARCHIVES","Использовать maXcomment в Архивах");
DEFINE("_MXC_TEMPLATE","Шаблон");
DEFINE("_MXC_COMMENTS_SORTING","Сортировка комментариев");
DEFINE("_MXC_NEW_ENTRIES_FIRST","Новые первыми");
DEFINE("_MXC_NEW_ENTRIES_LAST","Новые последними");
DEFINE("_MXC_EXPL_COMMENTS_SORTING","Порядок сортировки комментариев");
DEFINE("_MXC_AUTOLIMIT_NUM_COMMENTS_PER_ARTICLE","Лимит количества комментариев на статью");
DEFINE("_MXC_UNLIMITED","Бесконечно");
DEFINE("_MXC_DISABLED_ADD_FORM","После достижения лимита, форма добавления комментариев будет автоматически отключена");
DEFINE("_MXC_COMMENTPERPAGE","Кол-во комментариев на страницу");
DEFINE("_MXC_EXPL_COMMENTPERPAGE","Количество комментариев, одновременно отображаемых на странице");
DEFINE("_MXC_EXPL_CHOOSE_TEMPLATE","Выберите шаблон комментариев");
DEFINE("_MXC_SHOWRSSFEED","Показывать RSS");
DEFINE("_MXC_DATEFORMAT","Формат даты");
DEFINE("_MXC_EXPL_DATEFORMAT","Определённый <strong><em>strftime</em></strong> формат даты (например : <strong><font color='green'>%d-%m-%Y %H:%M </font></strong>)");
DEFINE("_MXC_FEATURES","Разное");
DEFINE("_MXC_POPULAR","Популярность");
DEFINE("_MXC_SHOWICONPOPULAR","Показывать иконку популярности после хитов/просмотров");
DEFINE("_MXC_LIMITFORSHOWICONPOPULAR","Уровень популярности");
DEFINE("_MXC_HITS_VIEWS","Хитов/Просмотров");
DEFINE("_MXC_RATING_2","Оценка");
DEFINE("_MXC_USERS","Пользователи");
DEFINE("_MXC_REGISTERED_ONLY","Зарегистрированные");
DEFINE("_MXC_ALL_USERS","Все пользователи");
DEFINE("_MXC_EXPL_WHO_ADD_FAVOURITE","Выберите кто может одобрять статью");
DEFINE("_MXC_NUMBEROFFAVOURITES","Количество одобрений");
DEFINE("_MXC_EXPL_AFTER_VOTING_FAVOURITE","Количество ссылок, на одобренные статьи, показываемое после голосования");
DEFINE("_MXC_MENUS_FOR_FAVOURED","Меню для одобренного");
DEFINE("_MXC_HOWCREATEMENU_1","Создание ссылки для отображения &laquo; одобрено читателями &raquo;");
DEFINE("_MXC_HOWCREATEMENU_2","Создание ссылки для отображения &laquo; избранное &raquo; (для зарегистрированных пользователей)");
DEFINE("_MXC_POSTING","Написание");
DEFINE("_MXC_MAXCOMMENTLENGTH","Макс. длина комментария (символы)");
DEFINE("_MXC_BLANKFORUNLIMITED","Оставьте пустым, для неограниченной длины комментария");
DEFINE("_MXC_WRAPWORDLONGERTHAN","Переносить длинные слова (символы)");
DEFINE("_MXC_EXPL_WRAPWORDLONGER","Максимальное количество символов в одном слове. Не распространяется на ссылки.");
DEFINE("_MXC_BBCODESUPPORT","Поддержка BB Code");
DEFINE("_MXC_EXPL_BBCODESUPPORT","Если Да - в комментариях будут разрешены BB Codes");
DEFINE("_MXC_SMILIESSUPPORT","Поддержка эмотиконов");
DEFINE("_MXC_EXPL_SMILIESSUPPORT","Если Да - в комментариях будут разрешены эмотиконы (смайлики)");
DEFINE("_MXC_PICTURESUPPORT","Поддержка картинок");
DEFINE("_MXC_EXPL_PICTURESUPPORT","Если Да - пользователи смогут добавлять картинки в комментарии");
DEFINE("_MXC_MAX_WIDTH_PICTURESUPPORT","Макс. ширина картинки");
DEFINE("_MXC_EXPL_WIDTH_PICTURESUPPORT","Максимальная ширина картинки в комментариях");
DEFINE("_MXC_SHOWCHECKBOXFORCONTACT","Показывать опцию уведомления");
DEFINE("_MXC_EXPL_SHOWCHECKBOXFORCONTACT","Если Да - будет показана опция &laquo;Уведомлять меня о новых комментариях&raquo;");
DEFINE("_MXC_SECURITY","Безопасность");
DEFINE("_MXC_NOTIFYADMIN","Уведомлять администратора");
DEFINE("_MXC_EXPL_NOTIFYADMIN","Если Да - администратору будут отправляться уведомления о новых комментариях");
DEFINE("_MXC_ADMINEMAIL","Email администратора для уведомлений и жалоб");
DEFINE("_MXC_EXPL_ADMINEMAIL","Адрес электронной почты, на которую будут присылаться уведомления о новых комментариях и жалобы пользователей");
DEFINE("_MXC_FLOODPROTECTION","Защита от флуда");
DEFINE("_MXC_EXPL_FLOODPROTECTION","Время в течении которого пользователь не сможет добавить новый комментарий (секунды)");
DEFINE("_MXC_BADWORDSFILTER","Цензура");
DEFINE("_MXC_EXPL_BADWORDSFILTER","Если Да - мат и ругательства будут заменены на ***** в комментариях");
DEFINE("_MXC_INTEGRATION","Интеграция");
DEFINE("_MXC_SECURITYIMAGE","Защита от ботов");
DEFINE("_MXC_USESECURITYIMAGE","Использовать компонент Security Image");
DEFINE("_MXC_EXPL_USESECURITYIMAGE","Использовать защиту от ботов Captcha (требуется версия 4.1 или выше)");
DEFINE("_MXC_SPAMPREVENTION","Предотвращение спама");
DEFINE("_MXC_ASKIMET","Использовать сервис обнаружения спама Akismet");
DEFINE("_MXC_WORDPRESSKEYAPI","Ключ WordPress API");
DEFINE("_MXC_EXPL_WORDPRESSKEYAPI","Вы можете получить бесплатный ключ API <a href='http://wordpress.com/signup/' target='_blank'>зарегистрировавшись на WordPress.com</a>.");
DEFINE("_MXC_BLOGURL","URL блога");
DEFINE("_MXC_EXPL_BLOGURL","Если оставить пустым - будет использована переменная \$mosConfig_live_site");
DEFINE("_MXC_EXPL_USEASKIMET","Защита от спама в комментариях с помощью Akismet. Для подробной информации посетите <a href='http://akismet.com/' target='_blank'>www.akismet.com</a>");
DEFINE("_MXC_DELETEALLSPAM","Удалить весь спам");
DEFINE("_MXC_FILTERAKISMET","Фильтр Akismet");
DEFINE("_MXC_COMUNITYBUILDER","Community Builder");
DEFINE("_MXC_CBAUTORLINK","Ссылка на профиль автора");
DEFINE("_MXC_EXPL_CBAUTORLINK","Сделать имя автора ссылкой на профиль Community Builder");
DEFINE("_MXC_CBAUTORCOMMENTLINK","Ссылка на профиль пользователя");
DEFINE("_MXC_EXPL_CBAUTORCOMMENTLINK","Сделать имя оставившего комментарий ссылкой на профиль Community Builder");
DEFINE("_MXC_SHOWAVATARCBPROFILE","Показывать аватар из профиля CB");
DEFINE("_MXC_EXPL_SHOWAVATARCBPROFILE","Показывать аватар пользователя из профиля CB в комментариях?");
DEFINE("_MXC_MAXAVATARWIDTH","Макс. ширина аватара");
DEFINE("_MXC_VISUALRECOMMEND","VisualRecommend");
DEFINE("_MXC_USEVISUALRECOMMENDFORMAILFRIEND","Использовать VisualRecommend");
DEFINE("_MXC_EXPL_USEVISUALRECOMMENDFORMAILFRIEND","Заменить функцию Joomla на компонент VisualRecommend. Вы должны скрыть оригинальный плагин.");
DEFINE("_MXC_PIXELS","пикселей");
DEFINE("_MXC_LOADINGELEMENTS","Загружаемые объекты");
DEFINE("_MXC_SHOWDATECREATED","Показывать дату создания");
DEFINE("_MXC_SHOWDATEMODIFIED","Показывать время последнего обновления");
DEFINE("_MXC_SECTION","Секция");
DEFINE("_MXC_CATEGORY","Категория");
DEFINE("_MXC_KEYWORDS","Ключевые слова");
DEFINE("_MXC_QUOTETHIS","Цитировать эту статью на сайте");
DEFINE("_MXC_PRINT","Напечатать");
DEFINE("_MXC_SENDBYEMAIL","Послать по электронной почте");
DEFINE("_MXC_DELICIOUS","Сохранить на del.icio.us");
DEFINE("_MXC_RELATEDARTICLES","Похожие статьи");
DEFINE("_MXC_READMORE","Читать дальше");
DEFINE("_MXC_LINKORIMAGE","(ссылка или картинка)");
DEFINE("_MXC_LINK","Ссылка");
DEFINE("_MXC_IMAGE","Картинка");
DEFINE("_MXC_YES","Да");
DEFINE("_MXC_NO","Нет");
DEFINE("_MXC_SHOW_STATUT","Статус оставившего комментарий");
DEFINE("_MXC_EXPL_SHOW_STATUT","Показывает кто оставил комментарий - пользователь или посетитель (гость)");
DEFINE("_MXC_LABEL","Метка");
DEFINE("_MXC_MORECOMMENTS","Ещё комментарии...");
DEFINE("_MXC_ADDYOURCOMMENT","Добавить комментарий");
DEFINE("_MXC_REPLYTOTHISCOMMENT","Ответить на комментарий...");
DEFINE("_MXC_SEEALLREPLIES","Посмотреть все ответы - %s");
DEFINE("_MXC_REPLIES","ответы");
DEFINE("_MXC_REPORTTHISCOMMENT","Пожаловаться на этот комментарий");
DEFINE("_MXC_NOCOMMENT","Нет комментариев");
DEFINE("_MXC_RSSFEED","RSS feed на комментарии");
DEFINE("_MXC_QUOTETHISARTICLEONYOURSITE","Цитировать эту статью на вашем сайте");
DEFINE("_MXC_CREATELINKTOWARDSTHISARTICLE","Для создания ссылки, на эту статью на вашем сайте,<br />скопируйте текст ниже и вставьте на вашем сайте.");
DEFINE("_MXC_PREVIEWQUOTE","Предпросмотр:");
DEFINE("_MXC_GOBACKITEM","Обратно к статье");
DEFINE("_MXC_RSS_LASTCOMMENTS","последние комментарии");
DEFINE("_MXC_RSS_COMMENTON","Комментарий к");
DEFINE("_MXC_RSS_VIEWCOMMENT","показать комментарий");
DEFINE("_MXC_RSS_WRITTENBY","Написал:");
DEFINE("_MXC_COMMENTS_ARE_CLOSED","Добавление комментариев к этой статье запрещено");
DEFINE("_MXC_GOHOME","На главную страницу");
DEFINE("_MXC_YOURFAVOURED","Ваше избранное");
DEFINE("_MXC_YOURFAVOUREDUSER","Ваши избранные статьи");
DEFINE("_MXC_FAVOUREDUSERMUSTLOGIN","Только зарегистрированные пользователи могут добавлять в избранное.<br />Пожалуйста войдите или зарегистрируйтесь.");
DEFINE("_MXC_ADDFAVOURED","Добавить в избранное");
DEFINE("_MXC_RECOMMENDTHISARTICLE","Одобрили эту статью");
DEFINE("_MXC_YOUHAVEFAVOUREDTHISARTICLE","Вы уже добавили эту статью в избранное");
DEFINE("_MXC_THANKFAVOURED","Спасибо за выш выбор!");
DEFINE("_MXC_FAVOUREDREMOVE","Удалить");
DEFINE("_MXC_NOFAVOURED","Нет избранного");
DEFINE("_MXC_WHATYOUWANT","Переход:");
DEFINE("_MXC_FAVOUREDONLYREGISTERED","Только зарегистрированные пользователи могут одобрять. Пожалуйста войдите или зарегистрируйтесь.");
DEFINE("_MXC_REPORT","Жалоба");
DEFINE("_MXC_REPORTACOMMENT","Пожаловаться на комментарий");
DEFINE("_MXC_REPORTINTRO","Спасибо за то, что уделили своё время и сообщили о данном комментарии администратору сайта.");
DEFINE("_MXC_REPORTINTRO2","Пожалуйста, заполните эту небольшую форму и нажмите кнопку отправить.");
DEFINE("_MXC_REASON_REPORT","Причина жалобы");
DEFINE("_MXC_COMMENTINQUESTION","Комментарий под вопросом");
DEFINE("_MXC_THANKS4UREPORT","Спасибо, ваша жалоба была отправлена администратору сайта.");
DEFINE("_MXC_ERRORONSENDREPORT","Ошибка системы, не удалось отправить вашу жалобу администратору сайта.");
DEFINE("_MXC_BUTTON_SUBMIT","Отправить");
DEFINE("_MXC_REPORTONCOMMENT","Пожаловаться на комментарий");
DEFINE("_MXC_REPORTADMINEMAIL","Пользователь пожаловался на комментарий:");
DEFINE("_MXC_FORMREPORTVALIDATE","Пожалуйста, укажите причину, по которой вы жалуетесь на этот комментарий.");
DEFINE("_MXC_ENTERNAME","Имя");
DEFINE('_MXC_ENTERMAIL', 'E-mail'); 
DEFINE("_MXC_FORMVALIDATECOMMENT","Пожалуйста, напишите комментарий по теме данной статьи!");
DEFINE("_MXC_FORMVALIDATENAME","Пожалуйста, укажите своё имя");
DEFINE("_MXC_FORMVALIDATEMAIL","Пожалуйста, укажите ваш email");
DEFINE("_MXC_FORMVALIDATETITLE","Пожалуйста, укажите заголовок");
DEFINE("_MXC_ARTICLE","Статья");
DEFINE("_MXC_COMMENT_AN_ARTICLE","Оставить комментарий");
DEFINE("_MXC_COMMENTONLYREGISTERED","Только зарегистрированные пользователи могут оставлять комментарии. Пожалуйста, войдите или зарегистрируйтесь.");
DEFINE("_MXC_NOTIFY_ME_FOLLOW_UP","Уведомлять меня о новых комментариях");
DEFINE("_MXC_ADMINMAILSUBJECT","Новый комментарий в %s");
DEFINE("_MXC_ADMINMAIL","Доброго времени суток Одмин,\n\nПользователь оставил новый комментарий:\n");
DEFINE("_MXC_ADMINMAILFOOTER","Пожалуйста, не отвечайте на это сообщение, оно было сгенерированно автоматически и носит информационный характер.\n");
DEFINE("_MXC_USERSUBSCRIBEMAIL","Доброго времени суток %s,\n\nПользователь оставил новый комментарий:\n");
DEFINE("_MXC_SECURITYCODE_WRONG","Неверный код безопасности! Попробуйте ещё раз...");
DEFINE("_MXC_COMMENT_SAVED","Ваш комментарий добавлен! Если он не относится к теме статьи или носит рекламный характер - он будет удалён.");
DEFINE("_MXC_REGISTERED","Пользователь");
DEFINE("_MXC_GUEST","Гость");
DEFINE("_MXC_DISPLAY_X_RELATEDITEM","Показать X похожих статей");
DEFINE("_MXC_NO_RELATEDITEM","Нет похожих статей.");
DEFINE("_MXC_SHOWICONNEW","Показывать иконку Новое!");
DEFINE("_MXC_EXPL_SHOWICONNEW","Показывать иконку Новое! после создания статьи");
DEFINE("_MXC_DAYS_NEW","Сколько дней показывать иконку Новое!");
DEFINE("_MXC_VOTE","голос");
DEFINE("_MXC_VOTES","голосов");
DEFINE("_MXC_RELATED_ARTICLE_TO_THIS_ARTICLE","Статьи относящиеся к этой");
DEFINE("_MXC_SPAM","Спам");
DEFINE("_MXC_POTENTIALSPAM","Возможно спам");
DEFINE("_MXC_NOTSPAM","Не спам");
DEFINE("_MXC_FEEDBACKTOAKISMET","Если вы считаете, что сообщение было ошибочно определено как спам, сообщите об этом:");
DEFINE("_MXC_MSGFEEDBACKTOAKISMET","Это сообщение было проверенно на Akismet");
DEFINE("_MXC_SPAMALERT","Это сообщение было проверенно <a href='http://akismet.com' target='_blank'>Akismet.com</a> и было определено как спам. Оно направлено администратору для проверки перед публикацией.");
DEFINE("_MXC_WAITING","ожидание");
DEFINE("_MXC_SECONDS","секунд");
DEFINE("_MXC_ALL","Все");
DEFINE("_MXC_QUOTE","Цитата");
DEFINE("_MXC_COMMENTCLOSED","Комментирование отключено для этой статьи.");
DEFINE("_MXC_OPACITYEFFECTONIMAGE","Эффект прозрачности картинки");
DEFINE("_MXC_EXPL_OPACITYEFFECTONIMAGE","Отображение иконки или рисунка с эффектом прозрачности по наведению мыши");
DEFINE("_MXC_OPACITYEFFECTPERCENT","Прозрачность");
DEFINE("_MXC_EXPL_OPACITYEFFECTPERCENT","Значение эффекта прозрачности");
//added 23.07.07
DEFINE("_MXC_TITLE_CONFIRM_UNSUBSCRIBE","Вы правда хотите отписаться от подписки?");
DEFINE("_MXC_CONFIRM_UNSUBSCRIBE","Ваш запрос на отписание от рассылки на последующие комментарии был обработан и вступает в силу немедленно.");
DEFINE("_MXC_UNSUBSCRIBE_TO_COMMENT","Это сообщение было послано вам, так как вы пожелали получать уведомления о новых комментариях к данной статье. Вы можете отказаться от подписки, нажав на ссылку:");
DEFINE("_MXC_WRITEFIRSTCOMMENT","Напишите комментарий первым");
DEFINE("_MXC_SHOW_IP","Показывать IP пользователя оставившего комментарий");
// added in 1.0.3
DEFINE("_MXC_SHOW_FAVOUREDCOUNTER","Показывать кол-во одобрений");
DEFINE("_MXC_DISPLAY_TITLE_FIELD","Показывать поле заголовка");
DEFINE("_MXC_EXPL_DISPLAY_TITLE_FIELD","Поле заголовка.. Если отключено - заголовок не показывается в комментарии.");
DEFINE("_MXC_DISPLAY_EMAIL_FIELD","Показывать поле email");
DEFINE("_MXC_EXPL_DISPLAY_EMAIL_FIELD","Поле email.. Если отключено - E-mail не будет запрашиваться и все функции связанные с электронной почтой будут отключены.");
DEFINE("_MXC_GRAVATAR","Gravatar");
DEFINE("_MXC_SHOW_GRAVATAR_USER","Показывать Gravatar");
DEFINE("_MXC_EXPL_SHOW_GRAVATAR_USER","Показывать <a href='http://site.gravatar.com' target='_blank'>Gravatar</a> пользователя (глобально узнаваемый аватар). Поле Email должно быть включено.");
DEFINE("_MXC_REPLACE_CB_AVATAR","Заменять аватар CB");
DEFINE("_MXC_EXPL_REPLACE_CB_AVATAR_BY_GRAVATAR_USER","Заменять аватар из профиля CB - Gravatar'ом");
DEFINE("_MXC_CHOOSE_DEFAULT_GRAVATAR","Выберите рисунок gravatar по умолчанию");
DEFINE("_MXC_WARNING_CONFIG","<font color='red'>Внимание: проверьте вашу конфигурацию <b>mXcomment</b>!</font>");
DEFINE("_MXC_LANGUAGE","Язык");
DEFINE("_MXC_COMMENT_LANGUAGE","Язык комментариев:");

//  added in 1.0.5
DEFINE("_MXC_MATHGUARD","Mathguard");
DEFINE("_MXC_MATHGUARD_URL","<a href='http://www.codegravity.com/projects/mathguard/' target='_blank'>Mathguard</a>");
DEFINE("_MXC_MATHGUARD_SECURITY_QUESTION","Mathguard security question:");
DEFINE("_MXC_BLOCKIPADDRESSES","Block IP addresses");
DEFINE("_MXC_CPL_BLOCK_IP","Block IP");
DEFINE("_MXC_CPANEL","Home");

// added in 1.0.6
DEFINE("_MXC_SEE_ALL_VARS_TPL","See all variables can be used in a template");

?>