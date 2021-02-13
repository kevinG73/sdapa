<!-- Modal -->
<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog  modal-xl modal-dialog-scrollable">
        <!-- Modal content-->
        <div class="modal-content rounded-0 border border-primary">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title text-uppercase">Calcul du point critère</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-12">
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
                            <div class="form-group col-md-3">
                                <label for="inputDateNaissance">Date de naissance</label>
                                <input type="date" class="form-control" id="inputDateNaissance" name="date_naissance">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputNationalite">Nationalité</label>
                                <input type="text" class="form-control" id="inputNationalite" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <p class="text-uppercase text-primary">critères de selection</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-inline col-md-6">
                                <label for="inputTemps1" class="mr-2">Le temps passé en Licence</label>
                                <input type="number" class="form-control w-25" id="inputTemps1" name="temps" min="3"
                                       max="6"
                                       value="3">
                            </div>
                        </div>

                        <div class="form-row">
                            <p class="text-primary text-uppercase">Le nombre de mention obtenue</p>
                        </div>
                        <div class="form-row mb-3">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="liste_nombre_mentions">
                                    <tr>
                                        <th>Niveau</th>
                                        <th>AB</th>
                                        <th>B</th>
                                        <th>TB</th>
                                        <th>Nombre total de mention</th>
                                        <th>Moyenne pondérée</th>
                                    </tr>
                                    <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <tr class="w-100">
                                            <?php if ($i < 4): ?>
                                                <td class="text-uppercase align-middle">L<?= $i ?></td>
                                            <?php else: ?>
                                                <td class="text-uppercase align-middle">TOTAL</td>
                                            <?php endif; ?>
                                            <td class="align-middle" id="div_l<?= $i ?>_c1">
                                                <input type="number" min="0" max="14" value="0"
                                                       id="mention_l<?= $i ?>_c1" name="mention_l<?= $i ?>_c1"
                                                       class="form-control" onchange="calcul(this.id)"
                                                       oninput="calcul(this.id)">
                                            </td>
                                            <td class="align-middle" id="div_l<?= $i ?>_c2">
                                                <input type="number" min="0" max="14" value="0"
                                                       id="mention_l<?= $i ?>_c2" name="mention_l<?= $i ?>_c2"
                                                       class="form-control" onchange="calcul(this.id)"
                                                       oninput="calcul(this.id)"
                                            </td>
                                            <td class="align-middle" id="div_l<?= $i ?>_c3">
                                                <input type="number" min="0" max="14" value="0"
                                                       id="mention_l<?= $i ?>_c3" name="mention_l<?= $i ?>_c3"
                                                       class="form-control" onchange="calcul(this.id)"
                                                       oninput="calcul(this.id)"
                                            </td>
                                            <td class="align-middle" id="div_l<?= $i ?>_c4">
                                                <input type="number" min="0" max="14" value="0"
                                                       id="total_l<?= $i ?>_c4" disabled name="total_l<?= $i ?>_c4"
                                                       class="form-control" onchange="calcul(this.id)"
                                                       oninput="calcul(this.id)"
                                            </td>
                                            <td class="align-middle" id="div_l<?= $i ?>_c5">
                                                <input type="number" min="0" max="14" value="0"
                                                       id="total_l<?= $i ?>_c4" disabled name="total_l<?= $i ?>_c4"
                                                       class="form-control" onchange="calcul(this.id)"
                                                       oninput="calcul(this.id)"
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                </table>
                            </div>
                        </div>

                        <div class="form-row">
                            <p class="text-primary text-uppercase">moyennes </p>
                        </div>
                        <div class="form-row">
                            <div class="table-responsive">
                                <table class="w-100">
                                    <tr class="table table-bordered w-100">
                                        <td class="align-middle">Licence 1</td>
                                        <td><input type="number" name="moyl1" value="0" class="form-control w-100"
                                                   id="inputML1" min="0" max="20"></td>
                                        <td class="align-middle">Licence 2</td>
                                        <td class="align-middle"><input type="number" name="moyl2" value="0"
                                                                        class="form-control w-100"
                                                                        id="inputML2" min="0" max="20"></td>
                                        <td class="align-middle">Licence 3</td>
                                        <td class="align-middle"><input type="number" name="moyl3" value="0"
                                                                        class="form-control w-100"
                                                                        id="inputML3" min="0" max="20"></td>
                                        <td class="align-middle">Moyenne pondérée</td>
                                        <td class="align-middle"><input type="number" name="moyl3" value="0"
                                                                        class="form-control w-100"
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Femer</button>
            </div>
        </div>
    </div>
</div>
