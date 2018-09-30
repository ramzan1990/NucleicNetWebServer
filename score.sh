#!/bin/bash
source activate py3
python Scripts/Nucleic-Bind_HMM_ScoreSomeSequences.py --PredictionFolder DL_output --TestSequences $1 --Targetname 4f3t