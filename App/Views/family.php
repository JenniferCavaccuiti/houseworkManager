<h1>Voici les membres de la famille</h1>
<div class="col-11">
<p></p>
<button id="add" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalAdd">Ajouter un membre
</button>

    <p id="pseudoCheck"></p>

<p></p>
<table id="table" class="table table-hover">
    <thead>
    <tr>
        <th class="hide">Id</th>
        <th>Pseudo</th>
        <th>date de naissance</th>
        <th>droits</th>
        <th>mail</th>
        <th>Options</th>
    </tr>
    </thead>
    <tbody id="tab">
    <tr>
        <?php foreach ($datas as $member): ?>
        <form action="../public/index.php?p=member&idFamily=<?= $member->getIdFamily(); ?>" method="post">
            <th class="hide"><input type="text" name="idMember" class="form-control border-0"
                       value="<?= $member->getIdMember(); ?>" READONLY></th>
            <td><input type="text" name="pseudo" class="form-control border-0" id="pseudoValue-<?= $member->getIdMember(); ?>"
                       value="<?= $member->getPseudo(); ?>"  onblur="uniquePseudo(this)"/>
            </td>

            <td><input type="date"  name="birthday" class="form-control border-0"
                       value="<?= $member->getBirthday() ?>"></td>
            <td>
                <select name="grade" class="form-control border-0">
                    <option  value="0" <?php if($member->getGrade() == 0) echo 'selected'; ?>>Droits restreints</option>
                    <option  value="1" <?php if($member->getGrade() == 1) echo 'selected'; ?>>Tous les droits</option>
                </select>
            </td>
            <td><input type="email" name="mail" class="form-control border-0"
                       value="<?= $member->getMail(); ?>"></td>
            <td>
                <button type="submit" class="btn btn-success" name="action" value="update">Modifier</button>
                <button class="btn btn-danger" data-toggle="modal" data-target=".modalDelete-<?=$member->getIdMember(); ?>">Supprimer</button>
            </td>
        </form>
    </tr>

</div>

    <!--modale de suppression de membres-->
    <div class="modal fade modalDelete-<?=$member->getIdMember(); ?>"  role="dialog"
         aria-labelledby="exampleModalLabel-<?=$member->getIdMember(); ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-<?=$member->getIdMember(); ?>"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Etes-vous sur de vouloir supprimer <strong><?= $member->getPseudo(); ?></strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Non</button>
                    <form action="../public/index.php?p=member&action=delete" method="post">
                        <button type="submit" class="btn btn-primary" name="idMember"
                                value="<?= $member->getIdMember(); ?>">Oui</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
    </tbody>
</table>

<!--modale d'insertion-->

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog"
     aria-labelledby="Modal d'insertion"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un membre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../public/index.php?p=member&action=add" method="post">
                    <div class="row">
                        <input type="text" name="idFamily" value="<?= $_SESSION['idFamily']; ?>" HIDDEN/>
                        <div class="form-group col-6">
                            <label for="pseudo" class="col-form-label">Pseudo du membre : </label>
                            <input name="pseudo" class="form-control" type="text" id="newMember" maxlength="50" onblur="uniquePseudo(this)"/>
                            <p id="pseudoCheck2"></p>
                            <label for="birthday" class="col-form-label">Date de naissance : </label>
                            <input name="birthday" class="form-control" type="date"/>
                            <label for="mail" class="col-form-label">Adresse email : </label>
                            <input name="mail" class="form-control" type="email"/>
                        </div>
                        <div class="form-group col-6">
                            <label for="password" class="col-form-label">Mot de passe : </label>
                            <input id="password" name="password" class="form-control" type="password"/>
                            <label for="passwordverif" class="col-form-label" >Saisissez à nouveau le mot de passe : </label>
                            <input id="passwordverif" name="passwordverif" class="form-control" type="password" onkeyup="passwordVerification()"/>
                            <div id="err"></div>
                            <label for="grade" class="col-form-label">Droits du membre : </label>
                            <select name="grade" class="form-control">
                                <option value="0">Droits restreints</option>
                                <option value="1">Tous les droits</option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="action" value="add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function passwordVerification()
        {
            if(document.getElementById("password").value != document.getElementById("passwordverif").value) {
                document.getElementById("err").innerHTML = "<p style='color:#ff0000'>Les deux mots de passe ne sont pas identiques</p>";
            }
            else {
                document.getElementById("err").innerHTML = "<p style='color:green'>mot de passe valide</p>";
            }
        }
    </script>
</div>

<script type='text/javascript'>



    let param = <?php print  $idMember = $member->getIdMember(); ?>;

    function uniquePseudo(e) {
        let idPseudo = e.getAttribute('id');
        // console.log(idElement);

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {
                // console.log(xhr.responseText);
                let response = xhr.responseText;
                console.log(response);
                if (idPseudo === "newMember") {
                    if (response !== '0') {
                        document.getElementById('pseudoCheck2').innerHTML = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
                    } else {
                        document.getElementById('pseudoCheck2').innerHTML = "excellent choix !";
                    }
                }

                if (response !== '0') {
                    document.getElementById('pseudoCheck').innerHTML = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
                } else {
                    document.getElementById('pseudoCheck').innerHTML = "excellent choix !";
                }
            }
        }

        xhr.open("POST", "index.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        let pseudo = document.getElementById(idPseudo).value;
        // console.log(pseudo);
        xhr.send("p=member&action=checkPseudo&pseudo=" + pseudo);
    }
</script>


