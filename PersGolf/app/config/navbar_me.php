 <?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',

    // Here comes the menu strcture
    'items' => [

        'firstpage'  => [
            'text'  => 'Hem',
            'url'   => $this->di->get('url')->create('Firstpage'),
            'title' => 'Hem'
        ],

        'calender'  => [
            'text'  => 'Kalender',
            'url'   => $this->di->get('url')->create('Calender'),
            'title' => 'Kalender',
        ],

        'thinkings'  => [
            'text'  => 'Spontana Tankar',
            'url'   => $this->di->get('url')->create('Thought'),
            'title' => 'Spontana Tankar',
        ],

        'course'  => [
            'text'  => 'Spelade Banor',
            'url'   => $this->di->get('url')->create('Course'),
            'title' => 'Spelade Banor',
        ],

        'user'  => [
            'text'  => 'Profil',
            'url'   => $this->di->get('url')->create('User'),
            'title' => 'Profil',
        ],

        'link'  => [
            'text'  => 'Länkar',
            'url'   => $this->di->get('url')->create('Link'),
            'title' => 'Länkar',
        ],

        'other'  => [
            'text'  => 'Övrigt',
            'url'   => $this->di->get('url')->create('Other'),
            'title' => 'Övrigt',
        ],
    ],



    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
