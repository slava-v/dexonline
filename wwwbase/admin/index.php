<?php
require_once("../../phplib/util.php");
util_assertModerator(PRIV_ANY);
util_assertNotMirror();

$recountButton = Request::has('recountButton');

if ($recountButton) {
  util_recount();
  util_redirect("index.php");
}

$reports = [
  ['text' => 'Definiții nemoderate',
   'url' => 'admin/viewPendingDefinitions',
   'count' => Variable::peek('Count.pendingDefinitions'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Definiții cu greșeli de tipar',
   'url' => 'admin/viewTypos',
   'count' => Variable::peek('Count.definitionsWithTypos'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Definiții cu abrevieri ambigue',
   'url' => 'admin/randomAbbrevReview',
   'count' => Variable::peek('Count.ambiguousAbbrevs'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Definiții OCR neverificate',
   'url' => 'admin/definitionEdit',
   'count' => sprintf("%d (disponibile: %d)",
                      Variable::peek('Count.rawOcrDefinitions'),
                      OCR::countAvailable(session_getUserId())),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Definiții neasociate cu nicio intrare',
   'url' => 'admin/viewUnassociatedDefinitions',
   'count' => Variable::peek('Count.unassociatedDefinitions'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Intrări neasociate cu definiții / lexeme',
   'url' => 'admin/viewUnassociatedEntries',
   'count' => Variable::peek('Count.unassociatedEntries'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Lexeme neasociate cu nicio intrare',
   'url' => 'admin/viewUnassociatedLexems',
   'count' => Variable::peek('Count.unassociatedLexems'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Arbori neasociați cu nicio intrare',
   'url' => 'admin/viewUnassociatedTrees',
   'count' => Variable::peek('Count.unassociatedTrees'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Intrări ambigue',
   'url' => 'admin/viewAmbiguousEntries',
   'count' => Variable::peek('Count.ambiguousEntries'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Lexeme cu comentarii',
   'url' => 'admin/viewLexemsWithComments',
   'count' => Variable::peek('Count.lexemesWithComments'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Lexeme fără accent',
   'url' => 'admin/viewLexemsWithoutAccents',
   'count' => Variable::peek('Count.lexemesWithoutAccent'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Lexeme ambigue',
   'url' => 'admin/viewAmbiguousLexems',
   'count' => Variable::peek('Count.ambiguousLexemes'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Lexeme fără paradigme',
   'url' => 'admin/viewTemporaryLexems',
   'count' => Variable::peek('Count.temporaryLexemes'),
   'privilege' => PRIV_EDIT
  ],
  ['text' => 'Mențiuni despre arbori nestructurați',
   'url' => 'admin/viewTreeMentions',
   'count' => Variable::peek('Count.treeMentions'),
   'privilege' => PRIV_EDIT
  ],
];

$minModDate = Model::factory('Variable')
            ->where_like('name', 'Count.%')
            ->min('modDate');
$timeAgo = time() - $minModDate;

SmartyWrap::assign('structurists', User::getStructurists());
SmartyWrap::assign('reports', $reports);
SmartyWrap::assign('timeAgo', $timeAgo);
SmartyWrap::addCss('admin');
SmartyWrap::addJs('select2Dev', 'modelDropdown');
SmartyWrap::display('admin/index.tpl');
?>
