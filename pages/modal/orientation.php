<!-- Modal -->
<div class="modal fade" id="orientationModal" role="dialog">
    <div class="modal-dialog  modal-xl modal-dialog-scrollable">
        <!-- Modal content-->
        <div class="modal-content rounded-0 border border-primary">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title text-uppercase">Affectation manuelle d'un étudant dans un parcours</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="bg-danger text-white text-center">
                        <p id="error-message"></p>
                    </div>
                    <form id="forms" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <h5>Informations personnelles</h5>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputNom">Numero de carte Etudiant</label>
                                <input type="text" class="form-control" name="numero_carte" id="numero_carte" readonly>
                                <input type="hidden" class="form-control" name="etudiant_id" id="id_etudiant" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputNom">Nom</label>
                                <input type="text" class="form-control" id="inputNom" name="nom" placeholder="Nom"
                                       disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPrenom">Prénom</label>
                                <input type="text" class="form-control" id="inputPrenom" name="prenom"
                                       placeholder="Prénom"
                                       disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="selectParcours">parcours</label>
                                <select name="id_parcours" id="selectParcours" class="form-control">
                                    <option value="#">selectionner un parcours</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary" id="btn-save">enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
