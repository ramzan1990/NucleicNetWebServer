conda info --envs
source activate py3
python NucleicNet/protein_RNA_interaction_package/Scripts/Nucleic-Bind_HMM_ScoreSomeSequences.py --PredictionFolder Apo --TestSequences $1 --Targetname Apo