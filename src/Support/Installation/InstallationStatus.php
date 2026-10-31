<?php

namespace DFSmania\LaradminLte\Support\Installation;

/**
 * Enum representing the installation status of a publishable resource.
 */
enum InstallationStatus: string
{
    case Installed = 'Installed';
    case Updated = 'Updated';
    case Unchanged = 'Unchanged';
    case Skipped = 'Skipped';
    case Failed = 'Failed';
}
