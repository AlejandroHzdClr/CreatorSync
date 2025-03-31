<style>
    .logo {
        left: 100px;
        width: 75px;
        max-width: 100%;
    }

    nav{
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color:rgb(255, 255, 255);
        padding: 30px 100px;
    }

    .foto_perfil {
        width: 75px;
        height: 75px;
        border-radius: 50%;
    }

    .campana{
        width: 60px;
    }

    .der{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap:50px;
        right: 100px;
    }

    @media (max-width: 600px) {
        .logo {
            left: 10px;  
            width: 100px;
        }
    }
</style>
</head>
<body>
    <nav>
        <div class="izq">
            <img src="../Imgs/CreatorsSyncLogo.png" alt="CreatorsSyncLogo" class="logo" onclick="window.location.href = 'inicio.php'">
        </div>
        <div class="der">
            <img src="../Imgs/Campana.png" alt="Campana" class="campana">
            <?php
            session_start();
            if (isset($_SESSION['nombre']) && isset($_SESSION['id']) && isset($_SESSION['avatar'])) {
                $img=$_SESSION['avatar'];
                echo "<img src='$img' alt='Foto de perfil' class='foto_perfil' onclick=\"window.location.href = 'perfil.php'\">";
            } else {
                echo "<a href='iniciar_sesion.php'>Iniciar Sesion</a>";
            }
            ?>

        </div>
    </nav>
</body>

