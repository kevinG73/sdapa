<!-- Modal -->
<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog  modal-dialog-centered modal-lg">
        <!-- Modal content-->
        <div class="modal-content rounded-0 border border-primary">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title text-uppercase">Remplissez les champs ci-dessous pour déterminer </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="bg-danger text-white text-center">
                    <p id="error-message"></p>
                </div>
                <form id="forms" method="post" action="ajax/Calcul.php">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <h5>Informations personnelles</h5>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputNom">Numero de carte Etudiant</label>
                            <input type="text" class="form-control" name="numero_carte" id="numero_carte" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNom">Nom</label>
                            <input type="text" class="form-control" id="inputNom" name="nom" placeholder="Nom" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPrenom">Prénom</label>
                            <input type="text" class="form-control" id="inputPrenom" name="prenom" placeholder="Prénom"
                                   disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputDateNaissance">Date de naissance</label>
                            <input type="date" class="form-control" id="inputDateNaissance" name="date_naissance">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNationalite">Nationalité</label>
                            <input type="text" class="form-control" id="inputNationalite" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <h5>critères de selection</h5>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputTemps1">Le temps passé en Licence</label>
                            <input type="number" class="form-control w-25" id="inputTemps1" name="temps" min="3" max="6"
                                   value="3">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNbMention">Le nombre de mention obtenue</label>
                            <input type="number" class="form-control w-25" id="inputNbMention" name="nbr_mention"
                                   min="0" max="42" value="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <p class="text-primary text-uppercase">moyennes </p>
                    </div>
                    <div class="form-row">
                        <div class="table-responsive">
                            <table class="w-100">
                                <tr class="w-100">
                                    <td>Licence 1</td>
                                    <td><input type="number" name="moyl1" value="0" class="form-control w-100"
                                               id="inputML1" min="0" max="20"></td>
                                    <td>Licence 2</td>
                                    <td><input type="number" name="moyl2" value="0" class="form-control w-100"
                                               id="inputML2" min="0" max="20"></td>
                                    <td>Licence 3</td>
                                    <td><input type="number" name="moyl3" value="0" class="form-control w-100"
                                               id="inputML3" min="0" max="20"></td>

                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-row mt-3">
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary" id="btn-save">enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Femer</button>
            </div>
        </div>
    </div>
</div>
