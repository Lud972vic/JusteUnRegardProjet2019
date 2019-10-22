@extends('default')
@section('title')
    JusteUnRegard - Accueil - Vos photographies
@endsection

@section('content')
    <!-- Début : Mur de photo-->
    <!--
      - gallery-block, cards-gallery : Voir, le fichier CSS cards-gallery.css
      - container-fluid : La classe container-fluid permet à la grille d'occuper toute la largeur
      - jumbotron : Permet d'afficher un élément graphique que l'on place généralement en x de page, notre titre Mur de photo...
      -->
    <section class="gallery-block cards-gallery">
        <div class="container-fluid">
            <div class="jumbotron text-center">
                <h2>Mur de photographie</h2>
                <p>Quelques exemples de photographies de nos adhérents...</p>
            </div>

            {{$medias->links()}}

            <div class="row no-padding">
                @foreach($medias as $media)
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <div class="card border-0 transform-on-hoverTMP">
                            <img src="{{asset('img'. $media->url_media)}}" alt="{{$media->lib_media}}"
                                 class="card-img-top imgMurPhoto">
                            <div class="card-body cardBodyNone">
                                <h6 class="card-title text-secondary badge badge-light">
                                    <small><i class="fas fa-user"></i> {{$media->user->pseudo_adh}}</small>
                                    <small><i class="fas fa-tag"></i> {{$media->lib_media}}</small>
                                    <small><i class="fas fa-camera-retro"></i> {{$media->dt_creation_media}} <i
                                            class="fas fa-folder-open"></i>{{$media->categorie->lib_cat}}
                                    </small></h6>
                                <details class="card-text text-muted">
                                    <summary><small><i class="fas fa-keyboard"></i> {{$media->desc_media}}</small>
                                    </summary>
                                    @foreach($media->commentaire as $c)
                                        @foreach($users as $user)
                                            @if($user->id == $c->user_id)
                                                <br> <small class="badge badge-light">{{$user->pseudo_adh}}
                                                    : {{$c->created_at}} {{$c->lib_comm}}</small>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </details>
                                <div>
                                    <br>
                                    <form>
                                                <textarea name="monmessage" id="monmessage" cols="70"
                                                          rows="1"></textarea>
                                        <a href="{{asset('img'. $media->url_media)}}"
                                           class="btn btn-sm btn-outline-warning"><i class="fas fa-eye"></i>
                                            Zoom</a>
                                        <button class="btn btn-sm btn-outline-success buttonPaddingLeft"><i
                                                class="fas fa-pencil-alt"></i> Poster mon
                                            commentaire
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!--Début : Mode carousel quand on clique sur une image-->
    <script>
        baguetteBox.run('.cards-gallery', {
            animation: 'slideIn'
        });
    </script>

    <!--Début : Affichage la partie card-body quand la souris se trouve sur une image du mur de photo -->
    <script>
        /*On stocke dans x et y, les positions top et left du focus de l'image*/
        x = 0;
        y = 0;

        $('.card').mouseenter(function () {
            $(this).width('640px'); /*On agrandit la card*/
            $(this).find('.imgMurPhoto').height('191px').width('640px'); /*On agrandit la photo*/
            $(this).css('z-index', '999'); /*Position de la photo au dessus des autres*/
            $(this).find('.cardBodyNone').show('fadeOut'); /*On montre la cardbody avec le texte + bouton*/

            /*Valeur de l'image*/
            x = $(this).offset();
            y = $(this).offset();

            /*Si on se trouve sur une image différente de la 1ere colonne, on recalcul la position de l image focus*/
            if (y.left > 317.164) {
                $(this).offset({
                    top: x.top,
                    left: (y.left - 317.164)
                });
            }
            ;
        });

        $('.card').mouseleave(function () {
            // $(this).height('480px').width('317.164px');
            // $(this).find('.imgMurPhoto').height('480px').width('317.164px');
            $(this).css('z-index', '0');
            $('.cardBodyNone').hide();

            $(this).offset({
                top: x.top,
                left: (y.left)
            });
        });
    </script>
    <!--Fin : Affichage la partie card-body quand la souris se trouve sur une image du mur de photo -->
@endsection
