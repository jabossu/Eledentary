<?php

/*
*
*	Fichier de langue française pour le projet
*	gestionnaire dentaire
*
*/

$traduction = array (
//----------------------------------------------------------------------------
// Clef			=>			Des mots %parametre substitué% et encore des mots.
//============================================================================

// > Menu
'menu_title'		=>			"Navigation",
'administration'	=>			"Administration",
'patient_managing'	=>			"Données Patients",
'nb_patients'		=>			"Patients enregistrés :",
'nb_inscrits'		=>			"Étudiants inscrits :",
'back_to_top'		=>			"Retourner en haut",
'go_logs'			=>			"Accéder aux logs",
'about'				=>			"À propos...",

// > Profile box
'profile_title'		=>			"Bonjour %NAME%",
'new_users'			=>			"Nouveaux utilisateurs",
'no_new_user'		=>			"Aucun nouvel utilisateur",
'admin_messages'	=>			"Messages Admins",

// > Page 404
'404_title'			=>			"Erreur 404 : Page non trouvée",
'404_msg'			=>			"La page que vous cherchez ( </strong><em>%TEXTE%</em></strong> ) n'existe pas",

// Page 403
'403_title'			=>			"Erreur 403 : Accès refusé",
'403_msg'			=>			"Vous essayez surement d'accéder à une page dont l'accès est restreint sans y être autorisé.",
'back_home'			=>			"Retourner à l'Accueil",

// Accueil
'home'				=>			"Accueil",
'home_msg'			=>			"Bienvenue sur le gestionnaire de patients de la CMC Dentaire.<br>Ce site servira (une fois fini) aux étudiants en médecine dentaire de l'UMF. Il leur permettra d'accéder facilement aux information des patients dont ils ont besoin pour réaliser leux activités pratiques.<br/>Pour bénéficier de ce service, inscrivez vous.",
'last_news'			=>			"Dernières nouvelles / Last News",
'read_all'			=>			"Voir tout les articles",

// > Inscription
'page_inscription'	=>			"Inscription" ,
'inscription'		=>			"Inscription sur le site." ,
'success'			=>			"<strong>Inscription réussie :</strong>Veuillez attendre le mail d'approbation.",
'missing_infos'		=>			"Veuillez complétez les informations suivantes :",
'bad_infos'			=>			"Les informations reçues sont incohérentes.<br>Veuillez réessayer.",
'new_page'			=>			"Veuillez renseigner les champs suivants pour vous inscrire :",
'incorect_infos'	=>			"Veuillez vérifier les informations suivantes :",
'matricule_double'	=>			"Ce numéro de matricule est déjà utilisé.",
'sign_up'			=>			"S'inscrire",

// > Connexion
'page_connexion'	=>			"Connexion",
'missing_login'		=>			"Les informations saisies sont incompletes" ,
'incorect_login'	=>			"Identifiant / mot de passe erroné.",
'sign_in'			=>			"Connectez vous au site avec votre matricule et votre mot de passe.",
'approve_pending'	=>			"Votre compte n'a pas encore été approuvé.",
'status_banned'		=>			"Votre compte a été bloqué par un administrateur",
'logged_in'			=>			"Vous êtes connécté",
'identification'	=>			"Identification :",

// > Déconnexion
'page_deconnexion'	=>			"Déconnexion",
'loged_out'			=>			"Vous êtes déconnécté.",
'already_out'		=>			"Vous n'étiez pas connécté.",

// > Profile
'page_profile'		=>			"Mon profile",
'save'				=>			"Enregistrer les changements",
'action_approuver'	=>			"Approuver",
'action_bannir'		=>			"Bannir",
'action_supprimer'	=>			"supprimer",
'action_adminiser'	=>			"Nommer Admin",
'action_email'		=>			"Envoyer un mail",
'success_edit'		=>			"Utilisateur modifié.",
'success_approve'	=>			"Utilisateur approuvé.",
'success_ban'		=>			"Utilisateur banni.",
'success_chadmin'	=>			"L'utilisateur est maintenant administrateur.",

// > Changer de mot de passe
'page_reset_password'=>			"Changer de Mot de passe",
'forgot_password'	=>			"Mot de passe oublié ?",
'clef'				=>			"Clef :",
'matricule_invalide'	=>		"Le matricule saisi n'existe pas",
'email_invalide'	=>			"L'email saisi ne correspond pas",
'demande_existe'	=>			"<strong>Mail renvoyé</strong> : vérifiez vos spams",
'clef_invalide'		=>			"La clef de changement de mot de passe n'existe pas",
'password_invalide'	=>			"<strong>Mot de passe invalide</strong> : utilisez plus de 6 caractères alphanumérique, ou '@', '_', '-'",
'passwords_nomatch'	=>			"Le mot de passe et la confirmation sont différents",
'clef_envoyee'		=>			"<strong>Email envoyé</strong> : Un email contenant un lien vous a été envoyé. Vérifiez vos spams.",
'password_changed'	=>			"<strong>Mot de passe modifié</strong> : vous pouvez vous connecter avec votre nouveau mot de passe.",
'copiez_clef'		=>			"Vous pouvez copier la clef reçue par mail ici :",
'change_password_for'	=>		"Changement de mot de passe pour %NOM PRENOM% :",
'password_changed'	=>			"Mot de passe modifié pour %NOM PRENOM% ;<br/>Vous pouvez maintenant vous connecter avec ce mot de passe.",



// > Page de contact
'page_contact'		=>			"Contacter les Admins",
'write_message'		=>			"Écrivez votre message <small>(20 000 caractères maximum)</small>",
'msg_objet'			=>			"Objet :",
'msg_corps'			=>			"Votre message : <small>(BBcode simplifié activé)</small>",
'msg_send'			=>			"Envoyer",
'success_msg_send'	=>			"Votre message a bien été transmi.",
'error_msg_missing_infos'	=>	"Renseignez les informations suivantes :",
'error_msg_incorrect_infos'	=>	"Vérifiez les champs suivants :",
'objet'				=>			"objet du message",
'corps'				=>			"contenu du message",

// > Page des messages
'page_viewmessages'	=>			"Messages reçus",
'page_vm_msg'		=>			"N'oubliez pas de marquer les messages comme lu quand vous avez fini de les lire.",
'expediteur'		=>			"Expediteur",
'date'				=>			"Envoyé le",
'title_msg_unread'	=>			"Messages non-lus",
'title_msg_read'	=>			"Messages lus",

// > Page de Lecture de message
'page_readmessage'	=>			"",
'page_rm_msg'		=>			"N'oubliez pas de marquer les messages comme lu quand vous avez fini de les lire.",
'action_msg_markread'	=>		"Marquer comme lu",
'action_msg_markunread'	=>		"Marquer comme non lu",
'msg_send_by'		=>			"Message envoyé par ",

// > Liste de patients
'page_patients'		=>			"Liste des patients",
'initiales'			=>			"Initiales",
'pathologie'		=>			"Pathologie",
'details'			=>			"Détails",
'select_patho'		=>			"Filtrer par pathologie :", 
'filtrer'			=>			"Filtrer",
'create_patient'	=>			"Ajoutter un patient",

// > Profile de patient
'page_profile_patients'	=>			"Profile de patients",
'info_patient'		=>			"Informations Générales",
'info_pathologie'	=>			"Informations sur la pathologie",
'cnp'				=>			"C.N.P",
'dent'				=>			"Dent atteinte",
'info_contact'		=>			"Moyens de Contact",
'update_patient_ok'	=>			"Modifications enregistrées",
'register_patient_ok'	=>		"Patient enregistré",
'bad_form_patient'	=>			"Formulaire incorrecte : veuillez réessayer",
'bad_infos_patient'	=>			"Renseignez tout les champs suivants",
'register'			=>			"Enregistrer",


// > Liste des éléves inscrits
'page_eleves'		=>			"Élèves inscrits",
'page_eleves_msg'	=>			"Cliquez sur le nom d'un élève pour accéder aux détails de son profile." ,

// > Gestion des pathologies
'page_liste_patho'	=>			"Liste des pathologies",
'page_add_pathologies'=>		"Ajoutter des Pathologies",
'nom_patho_fr'			=>		"Pathologie : Nom français",
'details_patho_fr'		=>		"Détails (en)",
'nom_patho_en'			=>		"Pathologie : Nom anglais",
'details_patho_en'		=>		"Détails (en)",
'annees_soignantes'	=>			"Années concernées",
'patho_added'		=>			"Pathologie ajouttée",
'patho_edited'		=>			"Modifications enregistrées",
'patho_invalid'		=>			"<strong>Erreur :</strong> Veuillez bien renseigner les champs suivants",
'patho_deleted'		=>			"Pathologie supprimée avec succès",
'patho_suppr'		=>			"Supprimer la pathologie",

// > Page de news
'page_news'			=>			"Articles & News",
'write_post'		=>			"Rédaction :",
'fr_titre'			=>			"Titre (fr)",
'fr_contenu'		=>			"Article : version française",
'en_titre'			=>			"Titre (en)",
'en_contenu'		=>			"Article : version anglaise",
'publish_post'		=>			"Publier",
'delete_post'		=>			"Supprimer l'article",
'news_msg_success'	=>			"Le message a été publié.",
'delete_msg_success'=>			"Le message a été supprimé.",
'news_msg_new'		=>			"Écrivez un article dans les deux langues, puis cliquez sur publier.",
'news_msg_error'	=>			"Un problème est survenu avec votre formulaire. Contactez un administrateur.",
'news_missing_infos'	=>		"<strong>Champ vide :</strong> %info%",

// > Chat & discussion
'page_dentchat'		=>			"Dent'Chat",

// Variables
'nom'				=>			"Nom de famille",
'prenom'			=>			"Prénom",
'annee'				=>			"Année d'études",
'email'				=>			"Adresse Mail",
'telephone'			=>			"Numéro de téléphone",
'matricule'			=>			"Numéro de matricule",
'motDePasse'		=>			"Mot de Passe",
'confMotDePasse'	=>			"Confirmez le mot de passe",
'informations'		=>			"Informations :",

// Détails Etudiants
'all_years'			=>			"Toutes Années",
'3'					=>			"3ème Année",
'4'					=>			"4ème Année",
'5'					=>			"5ème Année",
'6'					=>			"6ème Année",
'nombre_soins'		=>			"Soins éfféctués",
'statut'			=>			"Statut",
'administrateur'	=>			"Administrateur",
'banni'				=>			"Banni",
'approuve'			=>			"Confirmé",
'nouveau'			=>			"En attente",
'all_status'		=>			"Tous",

// About Us :
'page_about_us'		=>			"Admins, Équipe & contacts" ,

// Wiki BBcode
'howto_bbcode'		=>			"Comment utiliser le BBCode ?",
'page_howto_bbcode'	=>			"Le BBcode",

// > Header
'site_name'			=>			"Gestionnaire de patients CMC Dentaire",
'site_title'		=>			"Site d'accès à la base de données de patients de la CMC Dentaire",

// > Footer
'copyryght'			=>			"CMC 2015, tout droits réservés",
'contributors'		=>			"Contributeurs : %NOMS%" );


