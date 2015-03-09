# Плагин для WordPress Donate With Robokassa (DWR) 
English version of this README could be found [at the bottom of this page](https://github.com/Malgin/dwr-wp-plugin#donate-with-robokassa-dwr-wordpress-plugin-english)

Плагин Donate With Robokassa поможет вам принимать пожертвования с помощью [Робокассы](http://robokassa.ru "Официальный вебсайт Робокассы")!

Робокасса - это платежный агрегатор, позволяющий принимать платежи с помощью огромного набора способов, включая QIWI, Вебмани, Яндекс.Деньги, Деньги@Mail.ru,
с помощью мобильных операторов (Мегафон, МТС), через терминалы, и не только!

С помощью этого плагина вы сможете добавить себе на сайт кнопку приема платежей произвольной суммы: 

![image](https://cloud.githubusercontent.com/assets/1384973/6256310/cbb23562-b7bf-11e4-9868-532b18fe5154.png)

Или же компактную кнопку для сайдбара, которая занимает совсем мало места. Нажав на неё, пользователь будет перенаправлен на страницу приема платежа,
а сумма платежа будет равняться сумме по умолчанию, выставляемой в настройках плагина!

![image](https://cloud.githubusercontent.com/assets/1384973/6256359/2cb64ca4-b7c0-11e4-91ad-f4efc222d127.png)

## Пожертвования
Я не собираю пожертвования, но буду благодарен если вы [поддержите проект](http://vertdider.com/pomoshh-proektu/ "Помощь проекту Vert Dider") по популяризации науки и научного подхода, в котором я принимаю участие как волонтер.

## Баги и пожелания для дальнейшего развития проекта
Если вам нравится мой плагин, но вы нашли в нем ошибку, пожалуйста, добавьте её в [багтрекер](https://github.com/Malgin/dwr-wp-plugin/issues) на Github странице плагина
А так же, если у вас есть пожелания для добавления нового функционала, создайте запрос на это изменение все в [том же багтрекере](https://github.com/Malgin/dwr-wp-plugin/issues)

## Предварительные требования
* Для того, чтобы использовать этот плагин эффективно, вам необходимо знать как работает Робокасса. Ознакомиться с ней можно на [официальном сайте](http://robokassa.ru "Официальный вебсайт Робокассы").
* На данный момент, этот плагин работает только если настройка "Постоянные ссылки" выставлена не по умолчанию.

## Как начать принимать пожертвования
Вам нужно проследовать этим ПЯТИ (**один из двух** последних необязателен) простым шагам:

1. Скачайте плагин и скопируйте его в папку 'site-root-dir/wp-content/plugins/donate-with-robokassa', где site-root-dir - корневая директория вашей WordPress установки.
2. В админпанели сайта, активируйте плагин (Это делается в меню "Плагины -> Установленные")
3. Откройте меню "Параметры -> Donate With Robokassa (DWR)" и заполните все необходимые поля (более детально о них можно почитать [ниже](https://github.com/Malgin/dwr-wp-plugin#%D0%A1%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0-%D0%BF%D0%B0%D1%80%D0%B0%D0%BC%D0%B5%D1%82%D1%80%D0%BE%D0%B2-donate-with-robokassa-dwr)).
4. Добавьте шорткод **[dwr_payment_widget]** в любую запись или на любую страницу, туда, где бы вы хотели видеть виджет приема платежей.
5. (Необязательно) Создайте две страницы, одна из которых будет сообщать пользователям об успешном завершении приема платежей, а вторая
- о том, что платеж провалился. Сделайте их URL красивыми и информативными (вы укажете URL этих страниц в настройках Робокассы как Success URL и Fail URL).
6. (Необязательно) Вместо создания двух отдельных страниц, в настройках Робокассы вы можете просто указать адрес вашего вебсайта для Success URL и Fail URL. Но это немного грубовато по отношению к пользователям.

Вот и все! Все готово.

## Шорткоды
Этот плагин поддерживает всего один шорткод: **[dwr_payment_widget]**. Если вы вставите этот шорткод в статью или на страницу, на его месте появится виджет приема оплаты с 
возможностью указать произвольную сумму оплаты.

Чтобы вставить **компактную кнопку**, вам нужно добавить пустой параметр 'compact' к шорткоду, вот так: **[dwr_payment_widget compact]**.

**Внимание!** Если обязательные (а это все) поля в настройках плагина не будут заполнены, вместо виджета на странице появится информирующее об этом сообщение. 

## Параметры
Плагин поддерживает два подраздела в меню Параметры:

* Параметры -> Donate With Robokassa (DWR)
* Параметры -> DWR - Статистика

#### Страница параметров Donate With Robokassa (DWR)
На этой странице находится список опций, которые необходимо заполнить чтобы плагин мог работать.

* Result URL для Робокассы.  
Эта опция описывает часть Result URL в настройках Робокассы, которая будет добавлена к hostname вашего сайта.
Рекомендуется оставить значение по умолчанию. Меняйте только если вы хорошо понимаете что вы делаете.  
_Пример_: Ваш вебсайт находится по адресу http://myonlineblog.com/. Если парамерт 'Result URL для Робокассы' оставлен по умолчанию (т.е. 'robokassa_result'), 
тогда в настройках магазина на сайте Робокассы параметр Result URL должен быть **http://myonlineblog.com/robokassa_result**.

* HTTP метод для Result URL  
Эта опция должна быть такой же, как и опция "HTTP метод для Result URL" в настройках магазина на сайте Робокассы.

* Идентификатор магазина  
Вы можете найти идентификатор мазаина в настройках вашего магазина на сайте Робокассы.

* Пароль #1 & Пароль #2  
Должны быть такими же, как и пароли, которые вы вводили в настройках магазина на сайте Робокассы.

* Сумма пожертвования по умолчанию  
Сумма, выставляемая по умолчанию в виджете с возможностью указывать произвольную сумму для оплаты, а также сумма, которая будет
использована при оплате при нажатии на компактную кнопку.

* Описание транзакции Robokassa  
Будет отображено в списке операций в магазине на сайте Робокассы.

* Принудительное удаление таблиц плагина  
Если этот чекбокс установлен, при деактивации плагина таблица со всеми транзакциями будет удалена.  
**Внимание!** В таблице содержится вся история транзакций, и если она будет потеряна, вся статистика будет также недоступна! 
(Хотя история тразакций сохраняется и доступна в настройках магазина на сайте Робокассы)

#### DWR - Статистика
На текущий момент эта страница отображает только 100 последних пожертвований и немного базовой статистики. Я _планирую_ поработать над этой частью, и
сделать статистику более репрезентативной и красивой.

## Локализация
Плагин локализован для английского и русского языков.

## Ещё раз
При деактивации плагин не удалит свою таблицу ('dwr_donations') из базы данных, т.к. при этом будет утеряна вся история пожертвований.  
Это означает что вы можете деактивировать плагин, а затем активировать его опять, и вся предыдущая история пожертвований будет доступна.  
В настройках есть чекбокс, выставив который, вы сможете удалить таблицу, деактивировав плагин.


# Donate With Robokassa (DWR) Wordpress Plugin (English)
Donate With Robokassa WordPress plugin helps you accept donations on your WP website with [Robokassa](http://robokassa.ru "Robokassa Website")!

Robokassa is a payment aggregator, which helps you accept payment via a wide variety of methods, including QIWI, WebMoney, Yandex.Money, Money@Mail.ru,
with different Mobile Operators (Megafon, MTC), via terminals, and others!

With this plugin, you will be able to add a robokassa widget with a field for arbitrary amount of donation, like this one:

![image](https://cloud.githubusercontent.com/assets/1384973/6256310/cbb23562-b7bf-11e4-9868-532b18fe5154.png)

Or you can add a compact button to your pages/sidebars which will lead to the robokassa payment page with default donation
value, which could be set on plugin settings page!

![image](https://cloud.githubusercontent.com/assets/1384973/6256359/2cb64ca4-b7c0-11e4-91ad-f4efc222d127.png)

## Donations
I do not accept donations, but I would be very gratitude if you will donate to [science populatization project](http://vertdider.com/pomoshh-proektu/ "Vert Dider") I work on as a volunteer.

## Bugs & Feature requests 
If you like my plugin, but find a bug in it, please create a bugreport on it's [official Github repository page](https://github.com/Malgin/dwr-wp-plugin/issues)
Also, if you have an idea how to improve the project further, please create feature requests [there, too](https://github.com/Malgin/dwr-wp-plugin/issues).

## Prerequisites
* In order to use this plugin, you should be familiar with Robokassa system. You can read about it on [Robokassa official website](http://robokassa.ru "Robokassa Website") (ru).
* This plugin _currently_ works only if Permalink Settings changed from Default.

## How to start accepting donations
You need to follow these FIVE (**one of two** at the end is optional) simple steps:

1. Download a plugin and copy it to 'site-root-dir/wp-content/plugins/donate-with-robokassa' folder.
2. In admin panel of the site, activate the plugin (You can do it under "Plugins -> Installed Plugins" menu).
3. Go to Settings -> Donate With Robokassa (DWR) page and fill in all the required fields (more details on this [here](https://github.com/Malgin/dwr-wp-plugin#donate-with-robokassa-dwr-settings-page)).
4. Add **[dwr_payment_widget]** shortcode anywhere on the website where you would like to see robokassa donation widget.
5. (Optional) Create two pages, one of which will inform your users about the success of the operation, and probably, thank them for
   the donation, and other will inform them that operation has failed. Make their URLs nice and informative (you will pass these URLs in Robokassa admin panel as Success URL and Fail URL,
   both with GET method).
6. (Optional) Instead of creating separate pages, you could just set Success URL anf Fail URL to point to your websire homepage. But this is bit rude.

That's it! You're all set up.

## Shortcodes
This plugin supports one shortcode: **[dwr_payment_widget]**. Inserting just this shortcode in an article, or on a page, will result in
a widget with a field for arbitrary donation to appear on the page.

In order to insert **compact widget button**, you should add an empty 'compact' parameter to the shortcode, like this: **[dwr_payment_widget compact]**.

**Warning!** If required (which are all) options are not set in the plugin settings page, a warning message will be displayed instead of a widget.

## Settings
There's two settings sections for the plugin:

* Settings -> Donate With Robokassa (DWR)
* Settings -> DWR Statistics

#### Donate With Robokassa (DWR) Settings page
On this page, there's a list of options, required to be set before a plugin could operate.

* Robokassa Result URL.  
This option describes a part of Robokassa Result URL (a parameter in Robokassa shop settings), which will be attached to your website hostname.
It is recommended to leave this option with a default value. Change it only if you understand what are you doing.  
_Example_: Your website is http://myonlineblog.com/. If 'Robokassa Result URL' setting will be default (i.e. 'robokassa_result'), then you should
set Result URL on Robokassa shop settings page to **http://myonlineblog.com/robokassa_result**.

* Robokassa Result URL Method  
This should be the same, as on Robokassa shop settings page for Result URL.

* Merchant Login  
This is a so called **shop identifier**. You can find it on the settings page of your shop in Robokassa shop admin panel.

* Merchant Password #1 & Merchant Password #2  
Should be the same as the values you set in shop settings.

* Default donation amount  
The default amount set to the widget with a field for specifying donation, and default amount which will be used for a compact button.

* Robokassa transaction description  
The description of a Robokassa shop transaction. Will be displayed in the list of operations in admin panel of the shop.

* Force delete tables  
If this checkbox is set, on deactivation of a plugin a table with all transactions will be deleted.  
**Warning!** A table holds all transaction history, and if lost, all statistics will be lost too! (Though transaction history could be
viewed in the admin panel of the shop)

#### DWR Statistics
Currently, this page only displays a list of last 100 donations with a very basic statistics. I _plan_ to work on this part more, and make 
statistics more representative.

## Localization
The plugin is localized for English and Russian languages.

## Once again
The plugin will not delete it's DataBase table ('dwr_donations') on deactivation, due the possibility of loosing all donations history.  
This mean that you can deactivate a plugin, and then re-activate it, and all previous statistics will be available.  
There's a checkbox on the parameters page of the plugin to force delete the table on deactivation.
