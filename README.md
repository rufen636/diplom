# **Программное средство управления договорами с физическими и юридическими лицами на предоставление услуг доступа к сети «Интернет»**

Программное средство управления договорами представляет собой комплексную систему автоматизации всего жизненного цикла договорной работы интернет-провайдера. Оно обеспечивает централизованное управление договорами с физическими и юридическими лицами — от создания и согласования до подписания, исполнения и архивации. Система интегрирует процессы продаж, юристов, абонентского отдела и бухгалтерии, значительно сокращая время обработки документов и минимизируя ошибки. За счет автоматизации рутинных операций и встроенной аналитики решение повышает прозрачность, контролируемость и эффективность бизнес-процессов компании.

Ссылки на репозитории сервера и клиента
https://github.com/rufen636/diplom_client_server
---

## **Содержание**

1. [Архитектура](#Архитектура)
	1. [C4-модель](#C4-модель)
	2. [Схема данных](#Схема_данных)
2. [Функциональные возможности](#Функциональные_возможности)
	1. [Диаграмма вариантов использования(#Диаграмма_вариантов_использования)]
	2. [User-flow диаграммы](#User-flow_диаграммы)
3. [Детали реализации](#Детали_реализации)
	1. [UML-диаграммы](#UML-диаграммы)
	2. [Спецификация API](#Спецификация_API)
	3. [Безопасность](#Безопасность)
	4. [Оценка качества кода](#Оценка_качества_кода)
4. [Тестирование](#Тестирование)
	1. [Unit-тесты](#Unit-тесты)
	2. [Интеграционные тесты](#Интеграционные_тесты)
5. [Установка и  запуск](#installation)
	1. [Манифесты для сборки docker образов](#Манифесты_для_сборки_docker_образов)
	2. [Манифесты для развертывания k8s кластера](#Манифесты_для_развертывания_k8s_кластера)
6. [Лицензия](#Лицензия)
7. [Контакты](#Контакты)

---
## **Архитектура**

### C4-модель

Для описания архитектурных решений программного средства использована нотация C4-model, которая представляет архитектуру на четырех уровнях декомпозиции. Каждый последующий уровень детализирует предыдущий, включая четыре уровня абстракции: контекст, контейнеры, компоненты и код. На уровне контекста показывается обзор системы и ее взаимодействие с окружением. Для разрабатываемого программного средства контекстный уровень представлен ниже.

<!-- <img width="383" height="283" alt="image" src="https://github.com/user-attachments/assets/ff8c15b8-a461-4459-8c79-e7e50ed3ee5b" /> -->
<img width="794" height="450" alt="Снимок экрана 2025-09-25 в 19 24 18" src="https://github.com/user-attachments/assets/18e9faad-fbfc-49d3-ad96-bd08eb521e0b" />


Следующим уровнем представления архитектуры является контейнерный. В нем составные части архитектуры, определенные на контекстном уровне, декомпозируются для предоставления информации о технических блоках высокого уровня. Для разрабатываемого программного средства контейнерный уровень представлен ниже.

<!-- <img width="424" height="382" alt="image" src="https://github.com/user-attachments/assets/49eb09f7-27c7-4ccf-a0cf-d724232d7b72" /> -->
<img width="558" height="482" alt="Снимок экрана 2025-09-25 в 19 23 44" src="https://github.com/user-attachments/assets/76fad989-342c-45e4-ad85-3fe06adcd808" />


Следующим уровнем представления архитектуры является компонентный. В нем представляются внутренние блоки контейнеров, определенные на контейнерном уровне. Для разрабатываемого программного средства компонентный уровень представлен ниже.

<img width="470" height="366" alt="image" src="https://github.com/user-attachments/assets/e4274b27-12b5-4f73-87e7-6042d505c41a" />


Самым нижним уровнем представления архитектуры является кодовый. В нем представляется внутренняя организация компонентов, определенных 
на компонентном уровне. Для разрабатываемого программного средства кодовый уровень представлен ниже.

<img width="340" height="419" alt="image" src="https://github.com/user-attachments/assets/9eb579b8-eecf-4156-871a-d856c2969149" />


Таким образом была разработана архитектура программного приложения, в соответствии с которой оно было разработано. 
Чистая архитектура программного средства управления договорами строится на принципе разделения ответственности между слоями, где каждый слой решает строго определённую задачу и не зависит от технических деталей других. Это позволяет системе быть гибкой, масштабируемой и легко объяснимой – как для команды разработки, так и при защите архитектурных решений.
В центре находится слой бизнес-логики, который включает в себя основные сущности: договор, клиент (физическое и юридическое лицо), услуга доступа к интернету, платеж, а также бизнес-метрики – срок согласования, количество изменений, статус договора, финансовые показатели. Эти сущности описывают, как работает процесс управления договорами, и используются в сценариях создания, согласования, подписания и контроля исполнения. Например, сущность Contract содержит данные о клиенте, услугах, тарифах, сроках действия, а метрики агрегируют показатели эффективности workflow.
Слой сценариев реализует прикладную логику: создание договора по шаблону, согласование документа, подписание, контроль сроков действия, формирование отчетности. Каждый сценарий оформлен как отдельный use case, который принимает входные параметры, обрабатывает их с помощью бизнес-сущностей и возвращает результат. Например, CreateContractUseCase получает данные клиента и услуги, генерирует номер договора, применяет шаблон и возвращает готовый документ. ApproveContractUseCase управляет workflow согласования, а GenerateReportUseCase формирует аналитические отчеты по договорной деятельности.
Слой адаптеров связывает бизнес-логику с внешним миром. Контроллеры принимают HTTP-запросы, преобразуют их в команды или запросы и передают в соответствующие обработчики. Например, ContractController обрабатывает POST-запрос на создание договора, вызывает CreateContractHandler, а ReportController обрабатывает GET-запрос и вызывает GenerateReportHandler. DTO и мапперы преобразуют данные между слоями, репозитории реализуют доступ к базе, презентеры формируют ответ для UI.
Слой инфраструктуры реализует технические детали: Laravel – для бэкенд-логики и API, Vue.js SPA – для интерактивного интерфейса управления, MySQL – для хранения данных договоров и клиентов, JWT – для авторизации и аутентификации пользователей. Eloquent ORM обеспечивает объектно-ориентированную работу с данными, а Vue Router и Vuex управляют состоянием клиентского приложения.



### Схема данных

С учётом специфики сервиса управления договорами и тарифами, спроектирована реляционная модель данных, охватывающая ключевые сущности: пользователи, контракты, тарифы и система ролевых разрешений. Схема обеспечивает хранение информации о клиентах, договорах, тарифных планах и управлении доступом пользователей.
Пользователи (Users). Сотрудники и клиенты, использующие систему для управления контрактами и тарифами. Атрибуты:
1	id (PK): уникальный идентификатор;
2	name: ФИО пользователя;
3	email: адрес электронной почты (уникальное значение);
4	password: хэш пароля;
5	email_verified_at: дата подтверждения email;
6	created_at: дата регистрации;
7	updated_at: дата обновления данных.
Для предоставления различных прав доступа в системе предусмотрена ролевая модель управления доступом. Чтобы обеспечить масштабируемость и соответствие нормализации, роли и разрешения вынесены в отдельные таблицы roles, permissions, role_has_permissions и models_has_roles.
Контракты (Contracts). Договоры с клиентами на предоставление услуг. Атрибуты:
1	id (PK): уникальный идентификатор контракта;
2	user_id (FK → users.id): идентификатор пользователя;
3	contract_number: номер договора;
4	title: наименование договора;
5	start_date: дата начала действия;
6	end_date: дата окончания действия;
7	amount: сумма контракта;
8	status: статус контракта (active, completed, terminated);
9	description: подробное описание условий контракта.
Клиенты провайдера (Provider_clients). Клиента провайдера,которые пользуются услугами. Атрибуты:
1	id (PK): уникальный идентификатор клиента;
2	name: наименование юридического/физического лица;
3	type: юридическое/физическое лицо;
4	contact_person: контактное лицо;
5	email: адрес электронной почты;
6	phone: номер телефона;
7	address: юридический адрес;
8	inn: ИНН;
9	kpp: КПП;
10	status: статус клиента;
11	notes: дополнительные заметки.
12	user_id (FK → users.id): идентификатор пользователя-клиента;
Тарифы (Tariffs). Тарифные планы на предоставляемые услуги. Атрибуты:
1	id (PK): уникальный идентификатор тарифа;
2	name: название тарифа;
3	description: описание тарифного плана;
4	price: стоимость тарифа;
5	speed: скорость обслуживания;
6	duration_months: продолжительность действия в месяцах;
7	is_active: флаг активности тарифа;
8	sort_order: порядок сортировки.
9	user_id (FK → users.id): идентификатор пользователя-клиента;
Система ролей и разрешений. Управление правами доступа пользователей в системе. Атрибуты:
1	roles: роли пользователей с указанием названия и системы защиты;
2	permissions: разрешения с указанием названия и системы защиты;
3	role_has_permissions: связь ролей с соответствующими разрешениями;
4	models_has_roles: назначение ролей пользователям системы.
5	На основе выделенных сущностей и их атрибутов была построена физическая схема базы данных. Она представлена на рисунке 1. 










<img width="404" height="378" alt="image" src="https://github.com/user-attachments/assets/26768902-1ef3-4336-b646-96b89351ed8a" />



 

Рисунок 1 – Физическая схема базы данных

Данная схема соответствует третьей нормальной форме по следующим причинам:
1	Схема находится в первой нормальной форме, поскольку все атрибуты ее сущностей атомарны.
2	Схема находится во второй нормальной форме, так как она находится в первой нормальной форме и каждый неключевой атрибут находится в полной функциональной зависимости от ключа.
3	Схема находится в третьей нормальной форме, поскольку она находится во второй нормальной форме и каждый неключевой атрибут находится в нетранзитивной зависимости от первичного ключа.  

Система OrderFlow реализует микросервисную архитектуру с централизованной аутентификацией и распределенной авторизацией. Безопасность обеспечивается на нескольких уровнях:
– API Gateway – точка входа, проверка JWT токенов;
– Auth Service – сервис аутентификации и управления пользователями;
– Eureka Server – service discovery для взаимодействия сервисов.
Принципы безопасности:
1 Stateless аутентификация – использование JWT токенов без хранения сессий.
2 Централизованная точка входа – все запросы проходят через API Gateway.
3 Ролевая модель доступа – RBAC (Role-Based Access Control).
4 Шифрование паролей – BCrypt hashing.
5 Защита от CORS атак – настройка CORS политик.
6 Валидация на уровне бизнес-логики – проверка прав доступа к ресурсам.
Эти принципы формируют многоуровневую защиту, где каждый компонент системы вносит свой вклад в общую безопасность. Далее будет рассмотерно, как эти принципы реализуются на практике, начиная с процесса аутентификации.  

3 АУТЕНТИФИКАЦИЯ ПОЛЬЗОВАТЕЛЕЙ

3.1 Регистрация пользователя

Система поддерживает регистрацию трех типов пользователей:
– BUH – бухгалтер;
– MANAGER – менеджер;
– ADMIN – администраторы системы.
Процесс регистрации:
1 Пользователь отправляет данные через POST /api/auth/register.
2 Система проверяет уникальность email.
3 Пароль хешируется с помощью Hash::make.
4 Создается пользователь и связанная компания.
Пример кода регистрации:

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

Таким образом, процесс регистрации не только создает нового пользователя и связанную с ним компанию, но и немедленно предоставляет JWT токен для аутентификации. 

3.2 Аутентификация (вход в систему)

Процесс входа использует email и пароль:
1 Пользователь отправляет POST /api/auth/login.
2 Система ищет пользователя по email.
3 При успехе генерируется JWT токен.
4 Токен возвращается клиенту.
Пример кода входа:

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
Возвращаемый токен является «ключом» пользователя для доступа к защищенным ресурсам. Клиентское приложение должно сохранять этот токен и прикреплять его к заголовку Authorization каждого последующего запроса.

3.3 JWT токены

Структура JWT токена.
Header:

{
  "alg": "HS256",
  "typ": "JWT"
}
Payload:
 
{
  "sub": "user@example.com",
  "role": "SUPPLIER",
  "iat": 1730000000,
  "exp": 1730003600
}

Signature:
 
HMACSHA256(
  base64UrlEncode(header) + "." + base64UrlEncode(payload),
  secret
)

Реализация JWT Provider:

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Config;

class JwtProvider
{
    private $secretKey;
    private $expirationTime;

    public function __construct()
    {
        $this->secretKey = Config::get('jwt.secret');
        $this->expirationTime = Config::get('jwt.expiration', 3600); // 1 час по умолчанию
    }

    public function generateToken($email, $role)
    {
        $now = time();
        $expiryDate = $now + $this->expirationTime;

        $payload = [
            'sub' => $email,
            'role' => $role,
            'iat' => $now,
            'exp' => $expiryDate,
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function validateToken($token)
    {
        try {
            JWT::decode($token, $this->secretKey, ['HS256']);
            return true;
        } catch (ExpiredException $e) {
            return false; // Токен истек
        } catch (\Exception $e) {
            return false; // Общая ошибка валидации
        }
    }

    public function getEmailFromToken($token)
    {
        $payload = JWT::decode($token, $this->secretKey, ['HS256']);
        return $payload->sub;
    }

    public function getRoleFromToken($token)
    {
        $payload = JWT::decode($token, $this->secretKey, ['HS256']);
        return $payload->role;
    }
}
Этот JwtProvider является критически важным компонентом в Auth Service. Он централизует всю логику работы с токенами, обеспечивая их корректное создание и строгую валидацию. 

4 АВТОРИЗАЦИЯ И РАЗГРАНИЧЕНИЕ ДОСТУПА  

4.1 Ролевая модель (RBAC)  

Система использует три роли:
– BUH – бухгалтер;
– MANAGER – менеджер;
– ADMIN – администраторы системы.
Эта ролевая модель реализуется через хранение роли пользователя непосредственно в JWT токене. Как будет показано далее, это позволяет API Gateway и сервисам принимать быстрые решения об авторизации, просто считывая role из полезной нагрузки токена.

4.2 Защита на уровне мидлваров

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user= auth()->user();
        $route = $request->route()->getName();
        $section = explode(".",$route);
        $action = array_key_last($section);
        $model = array_key_first($section);

        $roles = [
            "moderator_$section[$model]",
            "admin"
        ];

        $actionMap = [
          'POST' => 'store',
          'GET' => 'show',
          'DELETE' => 'destroy',
          'PATCH' => 'update',
          'PUT' => 'update',
        ];

        $permissionName = $actionMap[request()->method()] ?? null;
        $role = $user->roles()->whereIn('title', $roles)->exists();
        $permission = $user->hasPermission($permissionName,$section[$model]);
        if(!$permission || !$role){return response()->json(['error' => 'Forbidden'], 403);}


        return $next($request);

    }
}
Мидлвар проверяет, до попадание в контроллер условия

4.3 Маршрутизация в API Gateway

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
Конфигурация маршрутизации тесно связана с безопасностью. Она гарантирует, что все запросы, начинающиеся с /api/auth/, /api/admin/ и т.д., будут направлены в auth-service.  

5 БЕЗОПАСНОСТЬ 

5.1 Результаты внедрения системы безопасности

API Gateway как единственная точка входа:
- все запросы проходят через Gateway;
- валидация JWT на уровне Gateway;
- маршрутизация запросов на основе путей с использованием маршрутов Laravel;
Auth Service как центр аутентификации:
- централизованное управление пользователями с помощью встроенной системы аутентификации Laravel;
- генерация и валидация JWT токенов с использованием пакета tymon/jwt-auth;
- управление ролями и правами доступа с помощью пакета spatie/laravel-permission;
Eureka Server для обнаружения сервисов:
- динамическая регистрация сервисов с использованием пакета для сервисного открытия, интегрируемого в Laravel;
- балансировка нагрузки между экземплярами, реализуемая через подходы к маршрутизации Laravel;
- проверка состояния сервисов с помощью встроенных возможностей Laravel или сторонних пакетов;
Распределенная авторизация:
- каждый сервис проверяет права доступа с помощью механизма авторизации Laravel;
- использование Middleware для проверки аутентификации и авторизации на уровне каждого сервиса;
- передача контекста пользователя через заголовки;
Внедрение этих компонентов безопасности трансформировало архитектуру в единую, защищенную систему. Централизация аутентификации и использование API Gateway являются основополагающими изменениями, повышающими безопасность и управляемость.








6 МЕХАНИЗМЫ ОБЕСПЕЧЕНИЯ БЕЗОПАСНОСТИ

6.1 Шифрование паролей (BCrypt)

BCrypt – это криптографическая хеш-функция для паролей, разработанная на основе шифра Blowfish.
Laravel использует встроенный механизм шифрования паролей с помощью алгоритма BCrypt. При создании пользователя его пароль автоматически хэшируется с использованием функции Hash::make(). Это обеспечивает безопасное хранение паролей, поскольку даже администраторы не могут увидеть оригинальные пароли пользователей.

use Illuminate\Support\Facades\Hash;

// Хэширование пароля при создании пользователя
$password = 'user-password'; // Оригинальный пароль
$hashedPassword = Hash::make($password);

// Сохранение в базе данных
$user = new User();
$user->password = $hashedPassword;
$user->save();

6.2 Защита от CORS атак

Laravel предоставляет возможность настройки CORS (Cross-Origin Resource Sharing) через пакет fruitcake/laravel-cors. Это позволяет контролировать, какие домены могут получать доступ к API вашего приложения. Настройки можно задать в файле конфигурации, что помогает предотвратить несанкционированный доступ к ресурсам.
CORS в API Gateway:

// В файле config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://your-allowed-domain.com'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];

6.3 Валидация входных данных

Laravel обеспечивает мощные механизмы валидации входных данных через объект Validator. Вы можете легко определить правила валидации для каждого поля формы, что позволяет гарантировать, что только корректные данные будут обработаны. Валидация может выполняться как на уровне контроллеров, так и через Form Request классы, что позволяет централизовать логику валидации.

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// В контроллере
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Логика для создания пользователя
}


6.4 Защита от SQL Injection

Laravel использует ORM Eloquent и Query Builder, которые автоматически экранируют данные, передаваемые в запросы. Это предотвращает SQL-инъекции, так как пользовательские данные никогда не включаются напрямую в SQL-запросы. Использование параметризованных запросов и методов Eloquent дополнительно усиливает защиту.

// Использование Eloquent
$user = User::where('email', $request->input('email'))->first();

// Использование Query Builder
$users = DB::table('users')->where('email', $request->input('email'))->get();

6.5 Логирование и аудит безопасности

Laravel включает в себя мощный механизм логирования, который можно настроить для записи различных событий, включая ошибки, предупреждения и действия пользователей. Логи могут быть записаны в различные каналы (файлы, базы данных и т. д.), что упрощает аудит безопасности и отслеживание подозрительных действий.

use Illuminate\Support\Facades\Log;

// Логирование события
Log::info('Пользователь вошел в систему', ['user_id' => $user->id]);

// Логирование ошибки
Log::error('Ошибка при создании пользователя', ['error' => $e->getMessage()]);
	


6.6 Защита от XSS атак

Laravel обеспечивает защиту от XSS (Cross-Site Scripting) атак через автоматическое экранирование выводимых данных. При использовании Blade-шаблонов данные, переданные пользователю, автоматически экранируются с помощью функции {{ }}, что предотвращает выполнение вредоносных скриптов. Дополнительно, вы можете использовать пакет spatie/laravel-html для более безопасного формирования HTML-кода.
// В Blade-шаблоне
<h1>{{ $user->name }}</h1> <!-- Автоматическое экранирование -->

// Можно использовать {!! !!} для безопасного вывода HTML, если вы уверены в его безопасности
{!! $user->bio !!} <!-- Используйте с осторожностью -->

































7 ИСПОЛЬЗУЕМЫЕ КОМПОНЕНТЫ

7.1 Spatie Laravel-permission

Пакет spatie/laravel-permission позволяет управлять ролями и правами доступа в вашем приложении. Он предоставляет удобные методы для создания и проверки ролей, а также для назначения прав пользователям. Это упрощает процесс управления доступом и обеспечивает гибкость в настройке уровня прав.

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user= auth()->user();
        $route = $request->route()->getName();
        $section = explode(".",$route);
        $action = array_key_last($section);
        $model = array_key_first($section);

        $roles = [
            "moderator_$section[$model]",
            "admin"
        ];

        $actionMap = [
          'POST' => 'store',
          'GET' => 'show',
          'DELETE' => 'destroy',
          'PATCH' => 'update',
          'PUT' => 'update',
        ];

        $permissionName = $actionMap[request()->method()] ?? null;
        $role = $user->roles()->whereIn('title', $roles)->exists();
        $permission = $user->hasPermission($permissionName,$section[$model]);
        if(!$permission || !$role){return response()->json(['error' => 'Forbidden'], 403);}


        return $next($request);

    }
}

7.2 LJWT (Laravel JWT)

Пакет tymon/jwt-auth используется для аутентификации пользователей с помощью JWT (JSON Web Tokens). Он обеспечивает создание, валидацию и управление токенами, позволяя реализовать безопасный механизм аутентификации в приложении. Это позволяет пользователям оставаться аутентифицированными без необходимости повторного ввода учетных данных.
Примеры использования:

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
7.3 Eloquent ORM

Eloquent — это встроенный ORM (Object-Relational Mapping) в Laravel, который упрощает взаимодействие с базой данных. Он позволяет работать с базой данных, используя объектно-ориентированный подход, что упрощает создание, чтение, обновление и удаление записей. Eloquent поддерживает отношения между моделями, что делает его мощным инструментом для работы с данными.

7.4 MySQL

Реляционная база данных. Конфигурация (.envl):

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=diplom
DB_USERNAME=root
DB_PASSWORD=Protectiv636

Выбор реляционной СУБД, такой как MySQL, позволяет использовать строгие схемы данных и транзакции, что способствует общей надежности и целостности системы. 






8 ПРИМЕРЫ КОДА

8.1 Регистрация пользователя (AuthController.php)

Ниже представлен код регистрации пользователя:

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','refresh']]);
    }

    public function refresh()
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);


        return response()->json(['token' => $newToken]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {

        $credentials = request(['email', 'password']);
        $email = request()->input('email');
        $user = User::withTrashed()->where('email', $email)->where('deleted_at','!=',null)->first();
        if ($user && $user->deleted_at) {
            $deletedAt = Carbon::parse($user->deleted_at);
            $oneMonthAgo = Carbon::now()->subMonth();

            if ($deletedAt > $oneMonthAgo) {
                $user->deleted_at = null;
                $user->save();
            }else{
                response()->json(['error' => 'Ваш аккаунт был удалён'], 404);
            }
        }

        if (!$token = auth()->attempt($credentials)) {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = Auth::user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'role' => $user->roles()->first()->title,
        ]);
    }
}


8.2 Логин пользователя (AuthService.php)

Ниже представлен код логина пользователя:

public function store($data)
{

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);
    if ($data['role'] === 'admin') {
        $user->roles()->attach(1); // Используем attach для добавления роли
    } elseif ($data['role'] === 'manager') {
        $user->roles()->attach(2); // Используем attach для добавления роли
    }

    return $user;
}

public function registerIfNot($data)
{
    $password = 'candidate' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $password,
    ]);

    $user->roles()->attach(2); // Используем attach для добавления роли
    Mail::to($data['email'])->send(new SendPasswordToStudent($user, $password));
    $token = auth()->login($user);
    return $this->respondWithToken($token);

}


8.3 Защита административных эндпоинтов (IsAdminMiddleware.php)

Ниже представлен код проверки защиты административных эндпоинтов:

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->is_admin){

            return $next($request);
        };

        return \response([
            'message' => 'forbidden',
        ], Response::HTTP_FORBIDDEN);
    }
}

Данный мидлвар яляется перехватчиком запроса, и проверяет админ ли пользователь, перед тем как попасть в контроллер


8.4 Модель пользователя (User.php)

Ниже представлен код модели пользователя:

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    public function tariff()
    {
        return $this->hasMany(Tariff::class);
    }
    public function providerClients()
    {
        return $this->hasMany(ProviderClient::class);

    }
}



---

## **Функциональные возможности**

### Диаграмма вариантов использования

Диаграмма вариантов использования и ее описание

### User-flow диаграммы

Описание переходов между части ПС для всех ролей из диаграммы ВИ (название ролей должны совпадать с тем, что указано на c4-модели и диаграмме вариантов использования)


---

## **Детали реализации**

### UML-диаграммы

Представить все UML-диаграммы , которые позволят более точно понять структуру и детали реализации ПС

### Спецификация API

Представить описание реализованных функциональных возможностей ПС с использованием Open API (можно представить либо полный файл спецификации, либо ссылку на него)

### Безопасность

Описать подходы, использованные для обеспечения безопасности, включая описание процессов аутентификации и авторизации с примерами кода из репозитория сервера

### Оценка качества кода

Используя показатели качества и метрики кода, оценить его качество

---

## **Тестирование**

### Unit-тесты

Представить код тестов для пяти методов и его пояснение

### Интеграционные тесты

Представить код тестов и его пояснение

---

## **Установка и  запуск**

### Манифесты для сборки docker образов

Представить весь код манифестов или ссылки на файлы с ними (при необходимости снабдить комментариями)

### Манифесты для развертывания k8s кластера

Представить весь код манифестов или ссылки на файлы с ними (при необходимости снабдить комментариями)

---

## **Лицензия**

Этот проект лицензирован по лицензии MIT - подробности представлены в файле [[License.md|LICENSE.md]]

---

## **Контакты**

Автор: email
