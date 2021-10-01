<?php
//ob_start();
$result = array();
//showLine("Checking php version...");
if (version_compare(PHP_VERSION, '5.4') >= 0) {
    $result[] = true;
//    showLine('OK<br />');
//    showLine('my version ' . PHP_VERSION . ' => 5.4 OK<br />');
} else {
    $result[] = false;
}

//showLine("Checking MCrypt PHP Extension...");
if (extension_loaded('mcrypt')) {
    $result[] = true;
//    showLine('OK<br />');
} else {
//    die('failed');
    $result[] = false;
}

//showLine("Checking Sqlite PHP Extension...");
if (extension_loaded('sqlite3')) {
    $result[] = true;
//    showLine('OK<br />');
} else {
//    die('failed');
    $result[] = false;
}

//showLine("Checking Zip Archive Class...");
if (class_exists('ZipArchive')) {
    $result[] = true;
//    showLine('OK<br />');
} else {
//    die('failed');
    $result[] = false;
}

$install = 4 == array_reduce($result, function($carry, $item){
    $carry += $item;
    return $carry;
});

//showLine("extracting...");
if ($install) {
    $zip = new ZipArchive;
    if ($zip->open('TurboBotBuilder.zip') === TRUE) {
        $zip->extractTo(__DIR__);
        $zip->close();
        $extracted = true;
    } else {
        $extracted = false;
    }
}

//ob_end_flush();


function showLine($line)
{
    echo $line;
    echo str_pad('',4096)."\n";
    ob_flush();
    flush();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Turbo Bot Builder Installer</title>

    <script src="//cdnjs.cloudflare.com/ajax/libs/vue/1.0.27/vue.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Custom CSS -->
    <style>
body {
    padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }

.bounce-transition {
    display: inline-block; /* otherwise scale animation won't work */
}
.bounce-enter {
    animation: bounce-in .9s;
}
.bounce-leave {
    animation: bounce-out .9s;
}
@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.5);
    }
    100% {
        transform: scale(1);
    }
}
@keyframes bounce-out {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.5);
    }
    100% {
        transform: scale(0);
    }
}

.table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
    border: none;
}

[v-cloak] {
    display: none;
}
    </style>


</head>

<body id="app">
    <!-- Page Content -->
    <div class="container" v-cloak>

        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 v-show="show" transition="bounce">Turbo Bot Builder Installer</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">

                <table class="table table-borderless">
                    <tr v-show="result[0]">
                        <td>

                            Checking php version  >= 5.4 ...
                        </td>
                        <td class="text-center">
                            <?php echo $result[0] ? "<green-tick></green-tick>" : "<red-cross></red-cross>" ?>
                        </td>
                    </tr>
                    <tr v-show="result[1]">
                        <td>
                            Checking MCrypt PHP Extension...
                        </td>
                        <td class="text-center">
                            <?php echo $result[1] ? "<green-tick></green-tick>" : "<red-cross></red-cross>" ?>
                        </td>
                    </tr>
                    <tr v-show="result[2]">
                        <td>
                            Checking Sqlite PHP Extension...
                        </td>
                        <td class="text-center">
                            <?php echo $result[2] ? "<green-tick></green-tick>" : "<red-cross></red-cross>" ?>
                        </td>
                    </tr>
                    <tr v-show="result[3]">
                        <td>
                            Checking Zip Archive Class...
                        </td>
                        <td class="text-center">
                            <?php echo $result[3] ? "<green-tick></green-tick>" : "<red-cross></red-cross>" ?>
                        </td>
                    </tr>

                    <tr v-show="result[4]">
                        <td>
                            Extracting Archive...
                        </td>
                        <td class="text-center">
                            <?php echo $extracted ? "<green-tick></green-tick>" : "<red-cross></red-cross>" ?>
                        </td>
                    </tr>


                    <tr v-show="result[5]" class="text-center">
                        <td colspan="99">
                            <?php
                            if (!$extracted)
                                echo "<div class='alert alert-danger' role='alert'>Can't unpack zip file, check your folder permissions.</span>";
                             else
                                echo $install ? "<a href='./' class='btn btn-success'>Run install</a>" : "<div class='alert alert-danger' role='alert'>Please fulfil server requirement </span>"    ?>
                        </td>
                    </tr>

                </table>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->


    <script>
        // define
        var GreenTick = Vue.extend({
            template: '<i class="icon ion-checkmark-circled" style="color: green"></i>'
        })
        var RedCross = Vue.extend({
            template: '<i class="icon ion-close-circled" style="color: red"></i>'
        })
        // register
        Vue.component('green-tick', GreenTick)
        Vue.component('red-cross', RedCross)

        var app = new Vue({
            el: '#app',
            data: {
                show: false,
                result: []
            }
        });
        app.show = !app.show;
//        app.result.$set(0,true);
        var index = 0;
        for(i=0;i<6;i++) {
            setTimeout(function() {
                console.log(index);
                console.log(app.result);
                showResutlRow(index++)
            }, (i+1)*1000);
        }

        function showResutlRow(index) {
            app.result.$set(index, true);
        }

    </script>

</body>

</html>

