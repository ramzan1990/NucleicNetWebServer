#!/bin/bash -i
echo "------------------------------------"
echo $1
python PromFind/pipeline/predictor_padding.py PromFind/model_1 $1 251 1 PromFind/files/output.txt
python PromFind/pipeline/choose_prom.py PromFind/files/output.txt