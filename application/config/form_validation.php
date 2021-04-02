<?php
$config = array(
//add category form validation array
'add_category' => array(
                array(
                    'field' => 'cat_name',
                    'label' => 'Category name',
                    'rules' => 'required|is_unique[product_category.category_name]',
                    'errors' => array('is_unique' => '%s is already exist!')
                )
            ),

//edit category form validation array
'edit_category' => array(
                array(
                    'field' => 'cat_name',
                    'label' => 'Category name',
                    'rules' => 'required'
                )
            ),

    //Register form validation array
    // 'register' => array(
    //                 array(
    //                     'field' => 'name',
    //                     'label' => 'name',
    //                     'rules' => 'required|min_length[4]|max_length[20]|trim'
    //                 ),
    //                 array(
    //                     'field' => 'email',
    //                     'label' => 'email',
    //                     'rules' => 'required|is_unique[register.email]|valid_email',
    //                     'errors' => array('is_unique' => 'This %s is already exist, please try new email!')
    //                 ),
    //                 array(
    //                     'field' => 'password',
    //                     'label' => 'Password',
    //                     'rules' => 'required|exact_length[6]'
    //                 ),
    //                 array(
    //                     'field' => 'confirm_password',
    //                     'label' => 'Password',
    //                     'rules' => 'matches[password]',
    //                     'errors' => array('matches' => 'The %s field does not match!')
    //                 ),
    //                 array(
    //                     'field' => 'phone',
    //                     'label' => 'phone',
    //                     'rules' => 'required|numeric|exact_length[10]'
    //                 ),
    //             ),
    
    //  //Edit form validation array
    // 'update' => array(
    //                 array(
    //                     'field' => 'name',
    //                     'label' => 'name',
    //                     'rules' => 'required|min_length[4]|max_length[20]|trim'
    //                 ),
    //                 array(
    //                     'field' => 'phone',
    //                     'label' => 'phone',
    //                     'rules' => 'required|numeric|exact_length[10]'
    //                 ),
    //             ),

    // //Send Email
    // 'email' => array(
    //                 array(
    //                     'field' => 'message',
    //                     'label' => 'message',
    //                     'rules' => 'required'
    //                 ),
    //                 array(
    //                     'field' => 'email',
    //                     'label' => 'email',
    //                     'rules' => 'required|valid_email',
    //                 ),
    //             ),

    // //Password update
    // 'password_update' => array(
    //                         array(
    //                             'field' => 'password',
    //                             'label' => 'password',
    //                             'rules' => 'required',
    //                         ),
    //                         array(
    //                             'field' => 'confirm_password',
    //                             'label' => 'password',
    //                             'rules' => 'matches[password]',
    //                             'errors' => array('matches' => 'The %s field does not match!'),
    //                         ),
    //                     ),
);
