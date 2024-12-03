<?php

namespace App;

enum TournamentStatus:Int
{
    case Completed = 1;

    case Upcoming  = 0;

    case Live = 2;

    case Canceled = 3;

}

// $(document).on('click','.pagination a', function(e){
//     e.preventDefault();
//     var page = $(this).attr('href').split('page=')[1];
//     var sort = null || $(this).attr('href').split('sort=')['sort'];
//     var dir = null || $(this).attr('href').split('dir=')['dir'];
//     getPage(sort, dir, page);
// });

// function getPage(sort, dir, page){
//     $.ajax({
//         url: '/admin/user/list?sort=' + sort + '&dir=' + dir + '&page=' + page
//     }).done(function(data){
//         $('.ajax').html(data);
//         $("html, body").animate({ scrollTop: 0 }, 200);
//     });
// }
