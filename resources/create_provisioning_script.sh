#!/bin/bash

cat drop_tables.sql <(echo) create_tables.sql <(echo) populate_tables.sql > provisioning.sql

