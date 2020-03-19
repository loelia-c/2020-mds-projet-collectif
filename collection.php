<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div id="wrapper" class="wrapper" v-cloak>
    <div class="header">
        <div class="recherche">
            Rechercher : <input type="text" v-model="searchString" placeholder="Entrer votre recherche" />
        </div>
    </div>
    <div class="content" v-if="affichage">

        <h2 class="lesLivres" id="lesLivres">Les Livres</h2>

            <div id="livres" v-for="l in filtrer">

                <img class="img-livre" :src="l.doc.visuel">
                <h3>{{ l.doc.titre }}</h3>
                <p class="auteur">
                    {{ l.doc.auteur }}
                </p>
                <p class="edition">
                    {{ l.doc.edition }}
                </p>
                <p class="genre">
                    Genre(s) :
                    <span v-for="liv in l.doc.genre"><?php echo "{{liv}} / "; ?></span>
                </p>

                <p class="tome">
                    {{ l.doc.tome }}
                </p>
                <p class="date_parution">
                    {{ l.doc.date_parution }}
                </p>
                <p class="nb_pages">
                    {{ l.doc.nb_pages }}
                </p>
                <p class="langue">
                    {{ l.doc.langue }}
                </p>
                <p class="resume">
                    {{ l.doc.resume }}
                </p>
                <p class="isbn">
                    {{ l.doc.isbn }}
                </p>


        </div>

        <a href="appli.php"><button>> Ajouter un livre <</button></a>
    </div>
    <div class="footer">
        Footer
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.5/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pouchdb@7.0.0/dist/pouchdb.min.js"></script>
<script>
    var db = new PouchDB('db_utilisateur');


    var livres = new Vue({
        el : '#wrapper',
        data : {
            searchString: "",
            tabLivres: [],
            affichage: false,
        },
        mounted()
        {
            var vm = this;
            db.sync('https://5f27fc86-3f3f-472c-a0a4-d8e736af858d-bluemix:c1f2fabb64ca498b4b4e93f1e2672f0361facfce1c1d932b59020b0f47ba6419@5f27fc86-3f3f-472c-a0a4-d8e736af858d-bluemix.cloudantnosqldb.appdomain.cloud/db_utilisateur')
                .then(function (doc) {
                    return db.allDocs({include_docs: true})
                }).then(function (doc) {
                vm.tabLivres = doc.rows;
                vm.affichage = true;
                // console.log(vm.tabLivres);
            }).catch(function (err) {
                console.log(err);
            });
        },

        computed : {
            filtrer : function(){
                var tableau = this.tabLivres;
                searchString = this.searchString;
                if(!searchString)
                {
                    return tableau;
                }
                searchString = searchString.trim().toLowerCase();



                // Filtre sur titre
                tableau = tableau.filter(function(livres){
                    if(livres.doc.titre.toLowerCase().indexOf(searchString) !== -1)
                    {
                        return livres;
                    }
                })

                return tableau;

            }
        },

    })



</script>
</body>
</html>