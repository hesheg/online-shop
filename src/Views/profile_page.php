<div class="container">
    <div class="profile-header">
        <div class="profile-img">
            <img src="" width="200" alt="Profile Image">
        </div>
        <div class="profile-nav-info">
            <h3 class="user-name"><h2><?php echo $user->getName(); ?></h2></h3>
            <div class="address">
                <p id="state" class="state">New York,</p>
                <span id="country" class="country">USA.</span>
            </div>

        </div>
        <div class="profile-option">
            <div class="notification">
                <i class="fa fa-bell"></i>
                <span class="alert-message">3</span>
            </div>
        </div>
    </div>

    <div class="main-bd">
        <div class="left-side">
            <div class="profile-side">
                <p class="email"><i class="fa fa-envelope"></i> <h2><?php echo $user->getEmail(); ?></h2></p>
                <div class="user-bio">
                    <h3>Bio</h3>
                    <p class="bio">
                        Lorem ipsum dolor sit amet, hello how consectetur adipisicing elit. Sint consectetur provident magni yohoho consequuntur, voluptatibus ghdfff exercitationem at quis similique. Optio, amet!
                    </p>
                </div>
                <div class="profile-btn">
                    <button class="chatbtn" id="chatBtn"><i class="fa fa-comment"></i> Chat</button>
                    <button class="createbtn" id="Create-post"><i class="fa fa-plus"></i> Create</button>
                </div>
                <div class="user-rating">
                    <h3 class="rating">4.5</h3>
                    <div class="rate">
                        <div class="star-outer">
                            <div class="star-inner">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                        <span class="no-of-user-rate"><span>123</span>&nbsp;&nbsp;reviews</span>
                    </div>

                </div>
            </div>

        </div>
        <div class="right-side">

            <div class="nav">
                <ul>
                    <li onclick="location.href='catalog'">Каталог</li>
                    <li onclick="location.href='cart'">Корзина</li>
                    <li onclick="location.href='edit-profile'">Редактировать профиль</li>
                    <li onclick="location.href='logout'"> Выйти</li>
                </ul>
            </div>
            <div class="profile-body">
                <div class="profile-posts tab">
                    <h1>Your Post</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa quia sunt itaque ut libero cupiditate ullam qui velit laborum placeat doloribus, non tempore nisi ratione error rem minima ducimus. Accusamus adipisci quasi at itaque repellat sed
                        magni eius magnam repellendus. Quidem inventore repudiandae sunt odit. Aliquid facilis fugiat earum ex officia eveniet, nisi, similique ad ullam repudiandae molestias aspernatur qui autem, nam? Cupiditate ut quasi iste, eos perspiciatis maiores
                        molestiae.</p>
                </div>
                <div class="profile-reviews tab">
                    <h1>User reviews</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam pariatur officia, aperiam quidem quasi, tenetur molestiae. Architecto mollitia laborum possimus iste esse. Perferendis tempora consectetur, quae qui nihil voluptas. Maiores debitis
                        repellendus excepturi quisquam temporibus quam nobis voluptatem, reiciendis distinctio deserunt vitae! Maxime provident, distinctio animi commodi nemo, eveniet fugit porro quos nesciunt quidem a, corporis nisi dolorum minus sit eaque error
                        sequi ullam. Quidem ut fugiat, praesentium velit aliquam!</p>
                </div>
                <div class="profile-settings tab">
                    <div class="account-setting">
                        <h1>Acount Setting</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit omnis eaque, expedita nostrum, facere libero provident laudantium. Quis, hic doloribus! Laboriosam nemo tempora praesentium. Culpa quo velit omnis, debitis maxime, sequi
                            animi dolores commodi odio placeat, magnam, cupiditate facilis impedit veniam? Soluta aliquam excepturi illum natus adipisci ipsum quo, voluptatem, nemo, commodi, molestiae doloribus magni et. Cum, saepe enim quam voluptatum vel debitis
                            nihil, recusandae, omnis officiis tenetur, ullam rerum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    @import url("https://fonts.googleapis.com/css?family=Poppins&display=swap");
    @import url("https://fonts.googleapis.com/css?family=Bree+Serif&display=swap");

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        background: #e9e9e9;
        overflow-x: hidden;
        padding-top: 90px;
        font-family: "Poppins", sans-serif;
        margin: 0 100px;
    }

    .profile-header {
        background: #fff;
        width: 100%;
        display: flex;
        height: 190px;
        position: relative;
        box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.2);
    }

    .profile-img {
        float: left;
        width: 340px;
        height: 200px;
    }

    .profile-img img {
        border-radius: 50%;
        height: 230px;
        width: 230px;
        border: 5px solid #fff;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        position: absolute;
        left: 50px;
        top: 20px;
        z-index: 5;
        background: #fff;
    }

    .profile-nav-info {
        float: left;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-top: 60px;
    }

    .profile-nav-info h3 {
        font-variant: small-caps;
        font-size: 2rem;
        font-family: sans-serif;
        font-weight: bold;
    }

    .profile-nav-info .address {
        display: flex;
        font-weight: bold;
        color: #777;
    }

    .profile-nav-info .address p {
        margin-right: 5px;
    }

    .profile-option {
        width: 40px;
        height: 40px;
        position: absolute;
        right: 50px;
        top: 50%;
        transform: translateY(-50%);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.5s ease-in-out;
        outline: none;
        background: #e40046;
    }

    .profile-option:hover {
        background: #fff;
        border: 1px solid #e40046;
    }
    .profile-option:hover .notification i {
        color: #e40046;
    }

    .profile-option:hover span {
        background: #e40046;
    }

    .profile-option .notification i {
        color: #fff;
        font-size: 1.2rem;
        transition: all 0.5s ease-in-out;
    }

    .profile-option .notification .alert-message {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #fff;
        color: #e40046;
        border: 1px solid #e40046;
        padding: 5px;
        border-radius: 50%;
        height: 20px;
        width: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .main-bd {
        width: 100%;
        display: flex;
        padding-right: 15px;
    }

    .profile-side {
        width: 300px;
        background: #fff;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
        padding: 90px 30px 20px;
        font-family: "Bree Serif", serif;
        margin-left: 10px;
        z-index: 99;
    }

    .profile-side p {
        margin-bottom: 7px;
        color: #333;
        font-size: 14px;
    }

    .profile-side p i {
        color: #e40046;
        margin-right: 10px;
    }

    .mobile-no i {
        transform: rotateY(180deg);
        color: #e40046;
    }

    .profile-btn {
        display: flex;
    }

    button.chatbtn,
    button.createbtn {
        border: 0;
        padding: 10px;
        width: 100%;
        border-radius: 3px;
        background: #e40046;
        color: #fff;
        font-family: "Bree Serif";
        font-size: 1rem;
        margin: 5px 2px;
        cursor: pointer;
        outline: none;
        margin-bottom: 10px;
        transition: background 0.3s ease-in-out;
        box-shadow: 0px 5px 7px 0px rgba(0, 0, 0, 0.3);
    }

    button.chatbtn:hover,
    button.createbtn:hover {
        background: rgba(288, 0, 70, 0.9);
    }

    button.chatbtn i,
    button.createbtn i {
        margin-right: 5px;
    }

    .user-rating {
        display: flex;
    }

    .user-rating h3 {
        font-size: 2.5rem;
        font-weight: 200;
        margin-right: 5px;
        letter-spacing: 1px;
        color: #666;
    }

    .user-rating .no-of-user-rate {
        font-size: 0.9rem;
    }

    .rate {
        padding-top: 6px;
    }

    .rate i {
        font-size: 0.9rem;
        color: rgba(228, 0, 70, 1);
    }

    .nav {
        width: 100%;
        z-index: -1;
    }

    .nav ul {
        display: flex;
        justify-content: space-around;
        list-style-type: none;
        height: 40px;
        background: #fff;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
    }

    .nav ul li {
        padding: 10px;
        width: 100%;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s ease-in-out;
    }

    .nav ul li:hover,
    .nav ul li.active {
        box-shadow: 0px -3px 0px rgba(288, 0, 70, 0.9) inset;
    }

    .profile-body {
        width: 100%;
        z-index: -1;
    }

    .tab {
        display: none;
    }

    .tab {
        padding: 20px;
        width: 100%;
        text-align: center;
    }

    @media (max-width: 1100px) {
        .profile-side {
            width: 250px;
            padding: 90px 15px 20px;
        }

        .profile-img img {
            height: 200px;
            width: 200px;
            left: 50px;
            top: 50px;
        }
    }

    @media (max-width: 900px) {
        body {
            margin: 0 20px;
        }

        .profile-header {
            display: flex;
            height: 100%;
            flex-direction: column;
            text-align: center;
            padding-bottom: 20px;
        }

        .profile-img {
            float: left;
            width: 100%;
            height: 200px;
        }

        .profile-img img {
            position: relative;
            height: 200px;
            width: 200px;
            left: 0px;
        }

        .profile-nav-info {
            text-align: center;
        }

        .profile-option {
            right: 20px;
            top: 75%;
            transform: translateY(50%);
        }

        .main-bd {
            flex-direction: column;
            padding-right: 0;
        }

        .profile-side {
            width: 100%;
            text-align: center;
            padding: 20px;
            margin: 5px 0;
        }

        .profile-nav-info .address {
            justify-content: center;
        }

        .user-rating {
            justify-content: center;
        }
    }

    @media (max-width: 400px) {
        body {
            margin: ;
        }

        .profile-header h3 {
        }

        .profile-option {
            width: 30px;
            height: 30px;
            position: absolute;
            right: 15px;
            top: 83%;
        }

        .profile-option .notification .alert-message {
            top: -3px;
            right: -4px;
            padding: 4px;
            height: 15px;
            width: 15px;
            font-size: 0.7rem;
        }

        .profile-nav-info h3 {
            font-size: 1.9rem;
        }

        .profile-nav-info .address p,
        .profile-nav-info .address span {
            font-size: 0.7rem;
        }
    }
    #see-more-bio,
    #see-less-bio {
        color: blue;
        cursor: pointer;
        text-transform: lowercase;
    }
    .tab h1 {
        font-family: "Bree Serif", sans-serif;
        display: flex;
        justify-content: center;
        margin: 20px auto;
    }

</style>