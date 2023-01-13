<?php

namespace Nifty;

class Migrations
{
    private $tables = [
        'menu',
        'user_roles',
        'users',
        'posts',
        'categories',
        'pages',
        'page_types',
        'social_networks',
        'social_accounts',
        'sessions'
    ];

    protected Db $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function migrate(array $args = []): void
    {
        if (empty($args)) {
            $this->createTables();
        }

        foreach ($args ?? [] as $arg) {
            $this->{$arg}();
        }
    }

    private function menu(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`page_id` INT(11) NULL',
            '`name` VARCHAR(60) NOT NULL',
            '`admin` TINYINT(1) NOT NULL DEFAULT 0',
            '`creator` TINYINT(1) NOT NULL DEFAULT 0',
            '`logged_in` TINYINT(1) NOT NULL DEFAULT 0',
            '`child_of` INT(11) NULL',
            '`dropdown` TINYINT(1) NOT NULL DEFAULT 0',
            '`new_section` TINYINT(1) NOT NULL DEFAULT 0',
            '`disabled` TINYINT(1) NOT NULL DEFAULT 0',
            '`status` TINYINT(1) NOT NULL DEFAULT 1',
            '`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function user_roles(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`name` VARCHAR(60) NOT NULL',
            '`admin` TINYINT(1) NOT NULL DEFAULT 0',
            '`creator` TINYINT(1) NOT NULL DEFAULT 0',
            '`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function users(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`email` VARCHAR(100) NOT NULL UNIQUE KEY',
            '`username` VARCHAR(30) NOT NULL',
            '`password` VARCHAR(255) NOT NULL',
            '`role_id` TINYINT(1) NOT NULL DEFAULT 3',
            '`registered_at` TIMESTAMP',
            '`status` TINYINT(1) NOT NULL DEFAULT 1',
            '`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function posts(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`category_id` INT(11) NOT NULL',
            '`author_id` INT(11) NOT NULL',
            '`title` VARCHAR(255) NOT NULL',
            '`slug` VARCHAR(255) NOT NULL',
            '`date` DATETIME',
            '`featured` INT(1) NOT NULL DEFAULT 0',
            '`featured_image` VARCHAR(255)',
            '`excerpt` TEXT',
            '`content` TEXT',
            '`kudos` INT(11) NOT NULL DEFAULT 0',
            '`status` TINYINT(1) NOT NULL DEFAULT 1',
            '`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function categories(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`name` VARCHAR(64) NOT NULL',
            '`status` TINYINT(1) NOT NULL DEFAULT 1',
            '`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function page_types(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`name` VARCHAR(255) NOT NULL',
            '`code` VARCHAR(255) NOT NULL'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function pages(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`page_type_id` INT(11) NOT NULL DEFAULT 1',
            '`main_page_id` INT(11) NOT NULL DEFAULT 0',
            '`user_id` INT(11) NULL',
            '`title` VARCHAR(255) NOT NULL',
            '`slug` VARCHAR(255) NOT NULL',
            '`content` TEXT',
            '`status` TINYINT(1) NOT NULL DEFAULT 1',
            '`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function social_networks(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`name` VARCHAR(64) NOT NULL UNIQUE KEY',
            '`domain` VARCHAR(255) NOT NULL',
            '`logo` VARCHAR(255) NULL',
            '`status` TINYINT(1) NOT NULL DEFAULT 1',
            '`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function social_accounts(): void
    {
        $fields = [
            '`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`social_id` INT(11) NOT NULL',
            '`user_id` INT(11) NULL',
            '`username` VARCHAR(255) NOT NULL',
            '`status` TINYINT(1) NOT NULL DEFAULT 1',
            '`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function sessions(): void
    {
        $fields = [
            '`id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`session` VARCHAR(32) NOT NULL',
            '`firstvisit` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ];
        $this->db->create(__FUNCTION__, $fields);
    }

    private function populate_menu(): void
    {
        $name = ['Home', 'About', 'Contact', 'Admin'];
        $admin = [0, 0, 0, 1];
        $creator = [0, 0, 0, 0];
        $logged_in = [0, 0, 0, 0];

        $size = count($name);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'name = :name',
                'admin = :admin',
                'creator = :creator',
                'logged_in = :logged_in'
            ];
            $values = [
                ':name' => $name[$i],
                ':admin' => $admin[$i],
                ':creator' => $creator[$i],
                ':logged_in' => $logged_in[$i]
            ];
            $this->db->upsert('menu', $fields, $values);
        }
    }

    private function populate_user_roles(): void
    {
        $name = ['admin', 'creator', 'guest'];
        $admin = [1, 0, 0];
        $creator = [1, 1, 0];
        $size = count($name);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'name = :name',
                'admin = :admin',
                'creator = :creator'
            ];
            $values = [
                ':name' => $name[$i],
                ':admin' => $admin[$i],
                ':creator' => $creator[$i]
            ];
            $this->db->upsert('user_roles', $fields, $values);
        }
    }

    private function populate_users(): void
    {
        $email = [
            'admin@nifty.com',
            'creator@nifty.com',
            'guest@nifty.com'
        ];
        $username = ['admin', 'creator', 'guest'];
        $password = [
            password_hash('admin', PASSWORD_DEFAULT),
            password_hash('creator', PASSWORD_DEFAULT),
            password_hash('guest', PASSWORD_DEFAULT)
        ];
        $role = [1, 2, 3];
        $registered_at = [
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ];
        $size = count($email);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'email = :email',
                'username = :username',
                'password = :password',
                'role_id = :role_id',
                'registered_at = :registered_at'
            ];
            $values = [
                ':email' => $email[$i],
                ':username' => $username[$i],
                ':password' => $password[$i],
                ':role_id' => $role[$i],
                ':registered_at' => $registered_at[$i]
            ];
            $this->db->upsert('users', $fields, $values);
        }
    }

    private function populate_categories(): void
    {
        $name = ['Technology', 'Lifestyle', 'Animals'];
        $size = count($name);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'name = :name'
            ];
            $values = [
                ':name' => $name[$i]
            ];
            $this->db->upsert('categories', $fields, $values);
        }
    }

    private function populate_page_types(): void
    {
        $name = [
            'Generic',
            'Generic Control Panel',
            'Privacy Policy',
            'About',
            'Terms and Conditions',
            'Legal',

        ];
        $code = [
            'GENERIC',
            'GENERIC_CONTROL_PANEL',
            'PRIVACY_POLICY',
            'ABOUT',
            'TERMS_AND_CONDITIONS',
            'LEGAL'
        ];

        $size = count($name);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'name = :name',
                'code = :code'
            ];
            $values = [
                ':name' => $name[$i],
                ':code' => $code[$i]
            ];
            $this->db->upsert('page_types', $fields, $values);
        }
    }

    private function populate_pages(): void
    {
        $page_type_id = [4, 2, 2, 2];
        $user_id = [1, 1, 1, 1];
        $title = ['About Me', 'Admin', 'Posts', 'Categories'];
        $slug = ['about-me', 'admin', 'posts', 'categories'];
        $content = ["A nice IT guy, that's all", "", "", ""];

        $size = count($page_type_id);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'page_type_id = :page_type_id',
                'user_id = :user_id',
                'title = :title',
                'slug = :slug',
                'content = :content'
            ];
            $values = [
                ':page_type_id' => $page_type_id[$i],
                ':user_id' => $user_id[$i],
                ':title' => $title[$i],
                ':slug' => $slug[$i],
                ':content' => $content[$i]
            ];
            $this->db->upsert('pages', $fields, $values);
        }
    }

    private function populate_posts(): void
    {
        $category = [1, 2, 2, 3, 3, 3];
        $title = [
            'Apple will release a new iOS',
            'Are you sleeping well? Here is our tips to sleep better',
            'A clever way to keep your inbox clear',
            'How to make your cat more social',
            '9 tips to improve your dog behavior',
            "Do people really like zoo's?"
        ];
        $slug = [
            'apple-will-release-a-new-ios',
            'are-you-sleeping-well-here-is-our-tips-to-sleep-better',
            'a-clever-way-to-keep-your-inbox-clear',
            'how-to-make-your-cat-more-social',
            '9-tips-to-improve-your-dog-begavior',
            'do-people-really-like-zoos'
        ];
        $author = [2,2,2,2,2,2];
        $date = [
            '2020-11-23 14:15:19',
            '2020-11-30 17:10:56',
            '2021-01-31 00:09:12',
            '2021-02-04 07:15:00',
            '2021-12-02 12:45:23',
            '2022-03-03 10:59:57'
        ];
        $excerpt = [
            'Nunc ut diam orci. Sed eu dolor a sapien pretium scelerisque non in sapien. In vehicula sem eu felis auctor ullamcorper. Proin mattis nulla a elit dapibus vulputate. Proin ullamcorper tellus a nibh accumsan laoreet. Aenean sed lorem dui. Praesent.',
            'Vestibulum interdum diam non libero hendrerit facilisis vitae sit amet mi. Nullam aliquam tortor ac diam fermentum, sit amet posuere tortor vehicula. Morbi egestas lorem ut bibendum sodales. Aliquam erat volutpat. Proin convallis id quam a scelerisque. Vivamus aliquam tempus.',
            'Maecenas pellentesque, mauris vel aliquet aliquam, libero lacus sodales nulla, ut vestibulum libero ipsum a felis. Maecenas in maximus massa, a scelerisque sem. Nullam elementum euismod convallis. Aenean ac quam scelerisque, feugiat elit nec, interdum justo. Maecenas congue efficitur cursus.',
            'Morbi dignissim efficitur commodo. Donec elementum blandit lorem, sit amet laoreet risus eleifend id. Duis placerat blandit ex ut pharetra. Integer eu erat nec libero volutpat ultrices a a ipsum. Donec aliquam orci ut tellus sollicitudin, at consectetur ex mollis.',
            'Vivamus quis risus feugiat leo pellentesque accumsan bibendum non odio. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam nec justo diam. Donec orci urna, ultricies eget sagittis dictum, venenatis vel mauris. Maecenas sodales elit augue, vitae sagittis.',
            'Aliquam tristique id lectus vel venenatis. Ut hendrerit mattis risus, non porta dolor tempor vitae. Donec auctor ex at dui porttitor, nec mattis sapien ullamcorper. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ac.'
        ];
        $content = [
            '<p>Aenean pulvinar lorem diam, eget tempor arcu maximus in. Quisque posuere, dolor in tempor placerat, massa ligula iaculis lorem, vitae congue libero risus pellentesque metus. Aliquam iaculis, lorem sit amet imperdiet pretium, ipsum est cursus mauris, sed vulputate mauris ipsum ut nunc. Phasellus tempor neque id pretium volutpat. Integer eu diam rutrum, pharetra ex vitae, hendrerit arcu. Sed mollis arcu sit amet lorem dictum, lacinia ultrices turpis mollis. Maecenas tortor diam, dignissim vitae molestie ac, tincidunt sit amet eros. Sed suscipit leo massa, ut pellentesque quam efficitur sed. Cras at dolor ante. Integer eu ante eget neque viverra hendrerit. In rutrum feugiat purus in viverra.</p>
            <p>Mauris tempor leo eget mauris ornare, in varius mauris tincidunt. Vivamus eu condimentum neque, non euismod mauris. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean egestas, nisi vitae malesuada facilisis, metus felis fermentum justo, vitae consequat orci lorem at mauris. Maecenas pharetra tristique velit, dictum placerat nisi dapibus id. Sed at nisl eget tortor eleifend fermentum. Aliquam arcu libero, sagittis ac ultrices vitae, porttitor nec velit. Proin enim massa, porta at scelerisque nec, condimentum sed tellus. Fusce a nulla dui. Vestibulum lobortis mauris ut augue pulvinar, non semper felis.</p>',

            '<p>Nullam aliquet arcu at dignissim rhoncus. Ut sed porttitor felis, et feugiat libero. Quisque id ultrices tellus. Donec eu aliquam sem, vitae pulvinar lacus. Donec vel ante a purus dapibus consectetur. Donec nisl mi, laoreet et pellentesque sit amet, efficitur in sapien. Proin aliquet tortor at posuere fermentum. Cras aliquam bibendum nisl at feugiat. Suspendisse neque eros, bibendum nec vehicula eget, suscipit non dolor.</p>
            <p>Nullam eu velit eros. Nullam quis eros quam. Donec suscipit magna eu magna auctor ultricies. Sed non turpis a velit tempor aliquet eget eu augue. Proin mollis, leo ac condimentum consectetur, ligula ex volutpat ipsum, in varius ligula magna ut magna. Curabitur quis suscipit justo. Vivamus varius arcu ut tortor laoreet, nec lacinia mauris tempus. Donec iaculis ac lectus at iaculis. Integer sem neque, sagittis sit amet tincidunt vitae, consequat aliquam purus. Donec faucibus pellentesque lacinia. Proin dictum, est id sagittis volutpat, odio magna posuere massa, ac scelerisque dolor ligula sit amet est. Ut risus magna, iaculis sed porta in, imperdiet ac neque. Ut lacinia lobortis sem eget convallis. Nulla facilisi. Fusce commodo ultrices facilisis. Aliquam erat volutpat. Vestibulum a eleifend sapien, a cursus mauris. Etiam nunc mi, malesuada vel malesuada sit amet, tincidunt in felis.</p>',

            '<p>Maecenas eget dui tempus, maximus tortor id, tempor orci. Phasellus luctus velit a molestie mattis. Vestibulum tempus nibh et tortor accumsan faucibus. Quisque bibendum rhoncus rhoncus. Praesent aliquam, odio at commodo bibendum, dui nisl consequat lorem, at finibus sapien erat in mauris. Nullam maximus non eros vel iaculis. Proin non fermentum neque, nec blandit nunc. Vivamus consectetur placerat sollicitudin. Mauris quis urna et leo faucibus volutpat. Vivamus cursus consequat libero sed suscipit. Quisque feugiat, quam in pharetra auctor, metus sem gravida diam, quis molestie magna quam eget dolor. Donec faucibus pulvinar lectus, in mollis elit tempor sed. Aliquam eu nisl posuere, lobortis sapien in, pharetra orci. Aenean finibus et est vel accumsan. Praesent hendrerit vel ex cursus consequat.</p>
            <p>Vestibulum aliquam sem vitae dui ultricies, at tincidunt neque dictum. Morbi hendrerit tellus et neque sagittis, sit amet molestie nulla volutpat. Etiam commodo dolor vitae dui sagittis ultricies. Aenean tellus tortor, sodales hendrerit tincidunt et, imperdiet aliquam libero. Ut pellentesque sed urna eget congue. Duis ipsum nunc, convallis et metus eu, iaculis sollicitudin turpis. Aenean sed ultricies tortor. Cras ac consectetur ante. Suspendisse et nulla feugiat, rhoncus nibh quis, luctus erat. Sed volutpat, felis non mollis cursus, est lectus porta arcu, sit.</p>',

            '<p>Praesent vel ipsum et enim facilisis consectetur at sit amet ligula. Pellentesque tempor quam elit, id egestas lorem condimentum eu. Nullam placerat eget magna at congue. Praesent cursus quam eget dui porta accumsan. In iaculis diam rhoncus faucibus mollis. Donec enim risus, commodo at enim non, gravida congue enim. Donec aliquam justo in risus suscipit rhoncus. Maecenas viverra dictum porta. Nam sem lorem, lobortis sit amet bibendum in, dapibus eu eros. Etiam volutpat nisi id dui dignissim, id efficitur ipsum iaculis. Suspendisse faucibus convallis neque. Duis sed ullamcorper nulla. In sem tortor, malesuada ut risus eget, hendrerit gravida turpis. Suspendisse rutrum malesuada ligula commodo venenatis. Quisque ultricies porta libero vel luctus.</p>
            <p>Suspendisse quis velit vel urna varius ultricies sed nec leo. Phasellus sed lectus elit. Suspendisse rhoncus ligula vel magna ullamcorper porttitor eget vitae tellus. Phasellus fringilla blandit ipsum. Nullam eleifend vitae lectus non mollis. Phasellus eu mauris at eros pulvinar tincidunt. Mauris semper, mauris id venenatis porttitor, tellus libero viverra turpis, vel fermentum lacus mi ac est. Nunc in aliquam justo. Suspendisse potenti. Vestibulum in metus nisl. Morbi quam neque, tincidunt sit amet leo posuere, sagittis mollis nibh. Donec dictum blandit nibh vel congue. Mauris faucibus sit amet magna.</p>',

            '<p>Nam sapien ipsum, maximus eu mollis id, fringilla rhoncus sapien. Etiam quis luctus elit. Morbi pulvinar, odio vel cursus semper, eros sem aliquet elit, at vestibulum mauris lacus ut dolor. Proin molestie ante quis sagittis lacinia. Aenean vel tincidunt magna. Suspendisse potenti. Donec vulputate sem quis nulla molestie consequat.</p>
            <p>Curabitur auctor erat ante, vel vestibulum ligula pretium eget. Quisque libero lectus, ullamcorper at venenatis eu, tempus sed nisl. Sed et lacinia turpis. Etiam id ultrices quam. Mauris neque metus, condimentum ac ex vel, ultrices venenatis tellus. Nullam eget semper elit. Vivamus eu mi sit amet diam tristique consectetur sed a orci. Praesent pretium massa id sem ultricies mollis. Maecenas a lacus at sapien varius dictum. Aliquam imperdiet pretium dolor sit amet ultrices. Suspendisse condimentum nibh lorem. Phasellus imperdiet pharetra quam, at porttitor ex vestibulum eu. Pellentesque vitae mi consectetur, commodo purus id, volutpat elit. Quisque consectetur, quam ac placerat aliquet, tortor neque rhoncus tellus, at dignissim eros sem porttitor tellus.</p>
            <p>Etiam eleifend ipsum sed odio gravida, in venenatis est pharetra. Sed dignissim cursus ullamcorper. In eget sem sapien. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer molestie tincidunt diam sollicitudin convallis. Ut venenatis mi.</p>',

            '<p>Donec non aliquet ex. Cras luctus lacinia mi, tristique semper dolor tincidunt vel. Suspendisse felis erat, ullamcorper quis blandit at, imperdiet ac orci. Donec viverra sem turpis, eu placerat arcu varius id. Vestibulum pharetra, ipsum quis ultricies dapibus, nibh erat ullamcorper neque, eget mattis quam metus sed purus. Suspendisse sodales ante urna, nec tempor nunc pellentesque vitae. Proin dignissim faucibus leo ac rutrum. In vitae facilisis urna. Pellentesque faucibus id lorem ut ornare. Phasellus felis turpis, ultricies dignissim facilisis at, tempor commodo magna. Aliquam a nisl mi. Sed mattis ante vel nulla aliquet, nec venenatis tortor mollis. In hac habitasse platea dictumst.</p>
            <p>Aliquam mollis lacinia consequat. Vivamus ut feugiat eros, ut consequat justo. Sed blandit imperdiet mi, in malesuada lorem cursus auctor. In aliquet tellus sed convallis lobortis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas posuere nunc at dolor rutrum, non sodales tellus pretium. Curabitur aliquam tempus nibh id ornare. Vestibulum vestibulum nibh lacus, eu ullamcorper nisl cursus ac. Fusce et odio ut erat ullamcorper rhoncus. Vestibulum quis neque velit. Aenean malesuada tortor est, quis lobortis felis bibendum eu. Pellentesque blandit justo imperdiet magna rhoncus posuere. Integer vulputate felis id dui ultricies condimentum. Cras.</p>'
        ];
        $size = count($category);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'category_id = :category_id',
                'author_id = :author_id',
                'title = :title',
                'slug = :slug',
                'date = :date',
                'excerpt = :excerpt',
                'content = :content'
            ];
            $values = [
                ':category_id' => $category[$i],
                ':author_id' => $author[$i],
                ':title' => $title[$i],
                ':slug' => $slug[$i],
                ':date' => $date[$i],
                ':excerpt' => $excerpt[$i],
                ':content' => $content[$i]
            ];
            $this->db->upsert('posts', $fields, $values);
        }
    }

    private function populate_social_networks(): void
    {
        $name = [
            'Twitter',
            'Facebook',
            'Instagram',
            'TikTok',
            'GitHub',
            'YouTube',
            'Reddit',
            'LinkedIn',
            'Pinterest'
        ];

        $domain = [
            'https://www.twitter.com/',
            'https://www.facebook.com/',
            'https://www.instagram.com/',
            'https://www.tiktok.com/',
            'https://www.github.com/',
            'https://www.youtube.com/',
            'https://www.reddit.com/',
            'https://www.linkedin.com/',
            'https://www.pinterest.com/'
        ];
        $size = count($name);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'name = :name',
                'domain = :domain'
            ];
            $values = [
                ':name' => $name[$i],
                ':domain' => $domain[$i]
            ];
            $this->db->upsert('social_networks', $fields, $values);
        }
    }

    private function populate_social_accounts(): void
    {
        $social = [1, 4];
        $username = ['nifty', 'nifty'];
        $user_id = [1, 1];
        $size = count($social);
        for ($i = 0; $i < $size; $i++) {
            $fields = [
                'social_id = :social_id',
                'username = :username',
                'user_id = :user_id'
            ];
            $values = [
                ':social_id' => $social[$i],
                ':username' => $username[$i],
                ':user_id' => $user_id[$i]
            ];
            $this->db->upsert('social_accounts', $fields, $values);
        }
    }

    private function createTables(): void
    {
        foreach ($this->tables as $table) {
            $this->{$table}();
        }
    }

    private function populate(): void
    {
        $this->createTables();
        foreach ($this->tables as $table) {
            $func = 'populate_'.$table;
            if (method_exists(__CLASS__, $func)) {
                $this->{$func}();
            }
        }
    }

    private function cleanTables(): void
    {
        foreach ($this->tables as $table) {
            $this->db->clean($table);
        }
    }

    private function dropTables(): void
    {
        $this->cleanTables();
        foreach ($this->tables as $table) {
            $this->db->drop($table);
        }
    }

    public function __destruct()
    {
        echo 'Job finished.'.PHP_EOL;
    }
}
