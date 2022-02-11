<?php

namespace Controller;

/**
 *
 */
class Template
{
    private $content;
    
    public function __construct($path, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . "/../Views/$path.php";
        $this->content = ob_get_clean();
    }

    public function __toString()
    {
        return $this->content;
    }

    public static function admin_menu_tabs()
    {
        $tabs = ['tabs' => [
            /*['name' => 'Escritorio', 'icon' => 'mdi-view-dashboard', 'url' => 'dashboard'],*/
            /*['name' => 'SEO', 'icon' => 'mdi-search-web', 'url' => 'seo'],*/
            /*['name' => 'Foro', 'icon' => 'mdi-post', 'url' => 'forum'],*/
            /*['name' => 'Medios', 'icon' => 'mdi-image-multiple', 'url' => 'library'],*/
            ['name' => 'Cursuri', 'icon' => 'mdi-library', 'url' => 'courses'],
            ['name' => 'Cursuri în așteptare', 'icon' => 'mdi-table-eye', 'url' => 'courses-pending'],
            ['name' => 'Aplicație pentru profesori', 'icon' => 'mdi-file', 'url' => 'teachers-application'],
            ['name' => 'Profesori pe acasă', 'icon' => 'mdi-account-switch', 'url' => 'teachers-homepage'],
            ['name' => 'Plăți', 'icon' => 'mdi-credit-card-outline', 'url' => 'payments'],
/*['name' => 'Cupones', 'icon' => 'mdi-ticket-percent', 'url' => 'coupons'],*/
            /*['name' => 'Calendario', 'icon' => 'mdi-calendar', 'url' => 'calendar'],*/
            /*['name' => 'Correos automatizados', 'icon' => 'mdi-email', 'url' => 'email-messages'],*/
            ['name' => 'Utilizatori', 'icon' => 'mdi-account-group', 'url' => 'users'],
            /*['name' => 'Estadísticas de Ventas', 'icon' => 'mdi-graph', 'url' => 'sales'],*/
        ],
        ];
        return $tabs;
    }
}
