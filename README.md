# xiangmuguanli
项目管理系统旨在为个人和团队提供高效便捷的项目管理解决方案。用户可以在系统上轻松创建和组织项目，详细记录项目类型、内容，并灵活设定子项目层级结构。系统支持明确项目负责人，设定清晰的开始和完成日期，确保项目进度可控。此外，系统还具备智能的临期提醒功能，帮助用户及时关注项目和任务的关键时间节点，避免延期。无论是个人任务规划还是团队协作管理，这款系统都能有效提升项目执行效率和管理水平。
#### 软件架构
![输入图片说明](https://foruda.gitee.com/images/1742215888257689773/dff3179f_1982398.png "屏幕截图")


#### 安装教程

- 后端:
- 确保您已安装 Composer。
- 在 backend 目录下运行 composer install 安装依赖。
- 配置 .env 文件中的数据库连接信息。
- 运行 php artisan migrate 创建数据库表。
- 运行 php artisan serve 启动 PHP 开发服务器 (默认监听 8000 端口)。
- 前端:
- 确保您已安装 Node.js 和 npm 或 yarn。
- 在 frontend 目录下运行 npm install 或 yarn install 安装依赖。   
- 运行 npm run dev 或 yarn dev 启动 Vue.js 开发服务器 (默认监听不同的端口，通常是 5173)。
- 访问系统:
- 
- 在浏览器中访问前端开发服务器的地址 (例如 http://localhost:5173)。


#### 使用说明

- 临期提醒 (后端 - 定时任务):
- 
- 您可以使用 Laravel 的 Task Scheduling 功能来创建定时任务。
- 
- 1. 创建邮件类 (app/Mail/ProjectNearExpiry.php 和 app/Mail/TaskNearExpiry.php):
- 
- 2. 修改 app/Console/Kernel.php:



```
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendExpiryReminders; // 确保引入您的命令

class Kernel extends ConsoleKernel
{
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SendExpiryReminders::class)->dailyAt('8:00'); // 每天早上 8 点运行
    }
}
```

- 3. 创建命令类 (app/Console/Commands/SendExpiryReminders.php) - 参考之前的代码片段。
- 
- 前端临期提醒:
- 
- 您可以在 frontend/src/components/Dashboard.vue 中添加一个部分，定期调用后端 API (您需要创建一个新的 API 接口来获取临期提醒) 来显示临期项目和任务。
