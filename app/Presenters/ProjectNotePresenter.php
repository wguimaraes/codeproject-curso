<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;
use CodeProject\Transformers\ProjectNoteTransformer;

/**
 * Description of ProjectPresenter
 *
 * @author William
 */
class ProjectNotePresenter extends FractalPresenter {
    
    public function getTransformer() {
        return new ProjectNoteTransformer();
    }
    
}
