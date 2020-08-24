export default {
    path: '/championships',
    name: 'championships',
    redirect: { name: 'ChampionshipList' },
    component: {
        template: '<div class="championship"><router-view></router-view></div>'
    },
    children: [
        {
            name: 'ChampionshipList',
            path: '',
            component: () => import('../components/Championship/index')
        },
        {
            name: 'ChampionshipAdd',
            path: 'new',
            component: () => import('../components/Championship/Add')
        },
        /*{
            name: 'ChampionshipUpdate',
            path: ':id/edit',
            component: () => import('../components/Championship/Update')
        },
        {
            name: 'ChampionshipShow',
            path: ':id',
            component: () => import('../components/Championship/Show')
        }*/
    ]
};
